<?php

namespace Joalvm\Modeller;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $conn = DB::connection()->getDoctrineConnection();
        $platform = $conn->getDatabasePlatform();
        dd($platform->getListTableConstraintsSQL('files'));
        $platform->registerDoctrineTypeMapping('enum', 'string');

        // $fks = $dsm->listTableDetails('files');
        // dd($fks);
    }
}
