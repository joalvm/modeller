<?php

namespace Joalvm\Modeller;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModellerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modeller:builder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera los modelos de una schema de base de datos.';

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
        $dsm = DB::connection()->getDoctrineSchemaManager();

        $fks = $dsm->listTableDetails('files');
        dd($fks);
    }
}
