<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generator
        {name : Class name on singular mode. Example: User}
        {--all : Generate controller, model, requests, routes, migration and views}
        {--controller : Generate controller}
        {--model : Generate model}
        {--request : Generate requests (Update and Store)}
        {--views : Generate views}
        {--routes : Generate routes}
        {--migration : Generate migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an basic CRUD for any Class';

    /**
     * The model name.
     *
     * @var string
     */
    protected $modelName;

    /**
     * The plural model name.
     *
     * @var string
     */
    protected $modelNamePlural;

    /**
     * The plural lower case model name.
     *
     * @var string
     */
    protected $modelNamePluralLowerCase;

    /**
     * The singular lower case model name.
     *
     * @var string
     */
    protected $modelNameSingularLowerCase;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $options = $this->options();

        $this->modelName = $name;
        $this->modelNamePlural = Str::plural($name);
        $this->modelNameSingularLowerCase = Str::lower($name);
        $this->modelNamePluralLowerCase = Str::lower(Str::plural($name));

        if ($options['controller'] || $options['all']) {
            $this->info('Generating the controller...');
            $this->controller();
        }

        if ($options['model'] || $options['all']) {
            $this->info('Generating the model...');
            $this->model();
        }

        if ($options['request'] || $options['all']) {
            $this->info('Generating the requests...');
            $this->request();
        }

        if ($options['routes'] || $options['all']) {
            $this->info('Generating the rota...');
            $this->routes();
        }

        if ($options['views'] || $options['all']) {
            $this->info('Generating the views...');
            $this->views();
        }

        if ($options['migration'] || $options['all']) {
            $this->info('Generating the migration...');
            $this->createMigration();
        }
    }

    protected function model()
    {
        $modelTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('Model')
        );

        file_put_contents(app_path("/{$this->modelName}.php"), $modelTemplate);
    }

    protected function controller()
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePluralLowerCase,
                $this->modelNameSingularLowerCase,
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/Admin/{$this->modelName}Controller.php"), $controllerTemplate);
    }

    protected function request()
    {
        $this->updateRequest();
        $this->storeRequest();
    }

    protected function updateRequest()
    {
        $requestTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNameSingularLowerCase,
            ],
            $this->getStub('UpdateRequest')
        );

        if (! file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Requests/Update{$this->modelName}Request.php"), $requestTemplate);
    }

    protected function storeRequest()
    {
        $requestTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNameSingularLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNameSingularLowerCase,
            ],
            $this->getStub('StoreRequest')
        );

        if (! file_exists($path = app_path('/Http/Requests'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Http/Requests/Store{$this->modelName}Request.php"), $requestTemplate);
    }

    protected function routes()
    {
        File::append(
            base_path('routes/web.php'),
            '
            /** Rotas para a tabela '.$this->modelName.' **/

            Route::resource(\''.$this->modelNamePluralLowerCase."', '{$this->modelName}Controller');

            "
        );
    }

    protected function createMigration()
    {
        $table = Str::snake($this->modelName);

        $this->call('make:migration', ['name' => 'create_'.$table.'_table', '--create' => $table]);
    }

    protected function views()
    {
        $path = resource_path('views/admin/'.$this->modelNamePluralLowerCase);
        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $this->viewIndex();
        $this->viewCreate();
        $this->viewEdit();
        $this->viewShow();
    }

    protected function viewIndex()
    {
        $viewIndexTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Index')
        );

        file_put_contents(resource_path('views/admin/'.$this->modelNamePluralLowerCase.'/index.blade.php'), $viewIndexTemplate);
    }

    protected function viewCreate()
    {
        $viewCreateTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Create')
        );

        file_put_contents(resource_path('views/admin/'.$this->modelNamePluralLowerCase.'/create.blade.php'), $viewCreateTemplate);
    }

    protected function viewEdit()
    {
        $viewEditTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Edit')
        );

        file_put_contents(resource_path('views/admin/'.$this->modelNamePluralLowerCase.'/edit.blade.php'), $viewEditTemplate);
    }

    protected function viewShow()
    {
        $viewShowTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralLowerCase}}',
            ],
            [
                $this->modelName,
                $this->modelNamePlural,
                $this->modelNameSingularLowerCase,
                $this->modelNamePluralLowerCase,
            ],
            $this->getStub('views/Show')
        );

        file_put_contents(resource_path('views/admin/'.$this->modelNamePluralLowerCase.'/show.blade.php'), $viewShowTemplate);
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }
}
