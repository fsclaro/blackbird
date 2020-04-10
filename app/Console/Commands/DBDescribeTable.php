<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DBDescribeTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:describe {table : Table name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exibe os detalhes sobre a estrutura de uma tabela.';

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
        $table = $this->argument('table');

        if ($this->tableDontExist($table)) {
            return $this->warn('Sorry, table not found.');
        }

        return $this->showTableDetails($table);
    }

    protected function tableDontExist($table)
    {
        return ! Schema::hasTable($table);
    }

    protected function showTableDetails($table)
    {
        $columns = DB::select("DESC {$table}");

        $headers = [
            'Field', 'Type', 'Null', 'Key', 'Default', 'Extra',
        ];

        $rows = collect($columns)->map(function ($column) {
            return get_object_vars($column);
        });

        return $this->table($headers, $rows);
    }
}
