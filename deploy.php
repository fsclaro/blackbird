<?php

namespace Deployer;

require 'recipe/laravel.php';

// Initial Parameters
set('application', 'blackbird');
set('default_stage', 'local');
set('repository', 'git@github.com:fsclaro/blackbird.git');
set('git_tty', true);
set('ssh_multiplexing', true);
set('keep_releases', 3);
set('default_timeout', 3600);
set('timezone', 'America/Sao_Paulo');

// cd /home/nandosal/www && (/usr/bin/git clone -b master --depth 1 --recursive  git@github.com:fsclaro/blackbird.git /home/nandosal/www/releases/1 2>&1)
// Laravel shared dirs
set('shared_dirs', [
    'storage',
]);

// Laravel shared file
set('shared_files', [
    '.env',
]);

// Laravel writable dirs
set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/app/public/uploads',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

// Servidor UNITAUEAD.COM.BR - 142.4.27.57
host('producao')
    ->hostname('nandosalles.com')
    ->user('nandosal')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '~/.ssh/known_hosts')
    ->stage('production')
    ->set('application', 'blackbird')
    // ->set('deploy_path', '/home/nandosal/www/{{application}}');
    ->set('deploy_path', '/home/nandosal/www');

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

desc('Deploy do sistema BLACKBIRD em nandosalles.com');
task('deploy', [
    'deploy:pre_install',
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',

    'artisan:storage:link',
    'artisan:view:clear',
    'artisan:cache:clear',
    'artisan:optimize',
    'deploy:post_install',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

task('deploy:pre_install', function() {
    writeln('<info>Sumário Executivo</info>');
    writeln('=================');
    writeln('');
    writeln('<info>✔</info> Aplicação............: <info>' . get('application') . '</info>');
    writeln('<info>✔</info> Estágio Padrão.......: <info>' . get('default_stage') . '</info>');
    writeln('<info>✔</info> Repositório..........: <info>' . get('repository') . '</info>');
    writeln('<info>✔</info> Nº de Cópias Mantidas: <info>' . get('keep_releases') . '</info>');
    writeln('<info>✔</info> Host.................: <info>' . get('hostname') . '</info>');
});

task('deploy:post_install', function () {
    writeln('<info>✔</info> Gerando o arquivo .env para <info>PRODUÇÃO</info>');
    runLocally('rsync -v -r -a ~/Projetos/blackbird/.env.producao nandosal@nandosalles.com:{{release_path}}/../../shared/.env');

    writeln('<info>✔</info> Limpando a instalação.');
    run('cd {{release_path}}; composer clear-all');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
