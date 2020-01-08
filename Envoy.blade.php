@setup
    $date = (new DateTime())->format('YmdHis');

    $user = "nandosal";
    $host = "nandosalles.com";
    $server = $user . "@" . $host;

    $repo = 'git@github.com:fsclaro/blackbird.git';
    $project = 'blackbird';
    $path = '~/projetos' . '/' . $project;
    $release = $path . '/' . $date;
    $healthUrl = "http://nandosalles.com/";
    $domain = "~/public_html/" . $project;

    $keep_releases = 3;
@endsetup

@servers(['web' => $server])

@task('status')
    echo "Status do deploy"
    echo "================"
    echo ""
    echo "User..........: {{ $user }}"
    echo "Host..........: {{ $host }}"
    echo "Server........: {{ $server }}"
    echo "Repository....: {{ $repo }}"
    echo "Release.......: {{ $release }}"
@endtask

@task('init')
    if [ ! -d {{ $path }}/current ]; then
        if [ ! -d {{ $path }} ]; then
            echo "Creating {{ $path }} directory"
            mkdir -p {{ $path }}
        fi

        cd {{ $path }}
        git clone {{ $repo }} {{ $release }}
        echo "Repository cloned"

        if [ -d {{ $path }}/storage ]; then
            echo "Deleting old storage directory"
            rm -rf {{ $path }}/storage
        fi

        mv {{ $release }}/storage {{ $path }}/storage
        ln -s {{ $path }}/storage {{ $release }}/storage
        ln -s {{ $path }}/storage/public {{ $release }}/storage/public
        echo "Storage directory set up"

        mv {{ $release }}/.env.producao {{ $path }}/.env
        rm {{ $release }}/.env
        ln -s {{ $path }}/.env {{ $release }}/.env
        echo "Environment file set up"

        rm -rf {{ $release }}
        echo "Deployment path initialised. Run 'envoy run deploy' now."
    else
        echo "Deployment path already initialised (current symlink exists)!"
    fi
@endtask

@story('deploy')
    deployment_start
    deployment_links
    deployment_composer
    deployment_migrate
    deployment_cache
    deployment_finish
    deployment_publish
    health_check
    deployment_option_cleanup
@endstory

@story('deploy_cleanup')
    deployment_start
    deployment_links
    deployment_composer
    deployment_migrate
    deployment_cache
    deployment_finish
    deployment_publish
    health_check
    deployment_cleanup
@endstory

@story('rollback')
	deployment_rollback
	health_check
@endstory

@task('deployment_start')
    printf "\033[0;32mTask: deployment_start\033[0m\n"
    cd {{ $path }}
    echo "Deployment ({{ $date }}) started"
    git clone {{ $repo }} {{ $release }}
    echo "Repository cloned"
@endtask

@task('deployment_links')
    printf "\033[0;32mTask: deployment_link\033[0m\n"
    cd {{ $path }}

    rm -rf {{ $release }}/storage
    ln -s {{ $path }}/storage {{ $release }}/storage
    ln -s {{ $path }}/storage/public {{ $release }}/public/storage
    echo "Storage directories set up"

    if [ -f {{ $release }}/.env ]; then
        rm {{ $release }}/.env
    fi
    ln -s {{ $path }}/.env {{ $release }}/.env
    echo "Environment file set up"
@endtask

@task('deployment_composer')
    printf "\033[0;32mTask: deployment_composer\033[0m\n"
    echo "Installing composer dependencies..."
    cd {{ $release }}
    composer install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader
@endtask

@task('deployment_migrate')
    printf "\033[0;32mTask: deployment_migrate\033[0m\n"
    php {{ $release }}/artisan migrate --env={{ $path }}/.env --force --no-interaction
@endtask

@task('deployment_cache')
    printf "\033[0;32mTask: deployment_cache\033[0m\n"
    php {{ $release }}/artisan view:clear --quiet
    php {{ $release }}/artisan cache:clear --quiet
    php {{ $release }}/artisan config:cache --quiet
    echo "Cache cleared"
@endtask

@task('deployment_finish')
    printf "\033[0;32mTask: deployment_finish\033[0m\n"
    php {{ $release }}/artisan queue:restart --quiet
    echo "Queue restarted"
    ln -nfs {{ $release }} {{ $path }}/current
    echo "Deployment ({{ $date }}) finished"
@endtask

@task('deployment_publish')
    printf "\033[0;32mTask: deployment_publish\033[0m\n"
    cd ~
    if [ -d {{ $domain }} ]; then
        rm -rf {{ $domain }}
    fi
    ln -s {{ $path }}/current {{ $domain }}
    echo "Project published."
@endtask

@task('health_check')
    printf "\033[0;32mTask: health_check\033[0m\n"
    echo "Checking Health"

    @if ( ! empty($healthUrl) )
        if [ "$(curl --write-out "%{http_code}\n" --silent --output /dev/null {{ $healthUrl }})" == "200" ]; then
            printf "\033[0;32mHealth check to {{ $healthUrl }} OK\033[0m\n"
        else
            printf "\033[1;31mHealth check to {{ $healthUrl }} FAILED\033[0m\n"
        fi
    @else
        echo "No health check set"
    @endif
@endtask

@task('deployment_option_cleanup')
    printf "\033[0;32mTask: deployment_option_cleanup\033[0m\n"
    cd {{ $path }}
    @if ( isset($cleanup) && $cleanup )
        find . -maxdepth 1 -name "20*" | sort | head -n -{{ $keep_releases }} | xargs rm -Rf
        echo "Cleaned up old deployments"
    @endif
@endtask

@task('deployment_cleanup')
    printf "\033[0;32mTask: deployment_cleanup\033[0m\n"
	cd {{ $path }}
	find . -maxdepth 1 -name "20*" | sort | head -n -{{ $keep_releases }} | xargs rm -Rf
	echo "Cleaned up old deployments"
@endtask

@task('deployment_rollback')
    printf "\033[0;32mTask: deployment_rollback\033[0m\n"
	cd {{ $path }}
	ln -nfs {{ $path }}/$(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1) {{ $path }}/current
	echo "Rolled back to $(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1)"
@endtask
