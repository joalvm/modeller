<?php

namespace Modeller;

use Illuminate\Support\Arr;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Types\StringType;

class ModellerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:models';

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
        $doctrine = $this->getDoctrine();

        $schemaManager = $doctrine->getSchemaManager();
        $platform = $doctrine->getDatabasePlatform();

        dd($platform->getListTableColumnsSQL('clients'));

        $result = $doctrine->executeQuery($this->getPostgres10TypesSQL());

        $types = array_map(function ($obj) {
            $obj['values'] = json_decode($obj['values'], true);

            if ('TYPE' === $obj['type']) {
                $obj['values'] = Arr::collapse($obj['values']);
            }

            return $obj;
        }, $result->fetchAll());

        foreach ($types as $type) {
            $this->line($type['name']);
            Type::addType($type['name'], StringType::class);
            $platform->registerDoctrineTypeMapping($type['name'], $type['name']);
        }

        dd($schemaManager->listTables());

        // $fks = $dsm->listTableDetails('files');
        // dd($fks);
    }

    public function getDoctrine(): Connection
    {
        return DB::connection()->getDoctrineConnection();
    }

    private function getPostgres10TypesSQL(): string
    {
        return "
            SELECT sqEnum.*
            FROM (
                SELECT 
                    t.typname AS \"name\",
                    'ENUM'::text AS \"type\",
                    json_agg(e.enumlabel)::json AS \"values\"
                FROM pg_type AS t
                JOIN pg_enum AS e on t.oid = e.enumtypid
                JOIN pg_catalog.pg_namespace AS n ON n.oid = t.typnamespace
                GROUP BY t.typname
            ) AS sqEnum
            UNION ALL
            SELECT sqType.*
            FROM (
                SELECT
                    u.user_defined_type_name AS \"name\",
                    'TYPE'::text AS \"type\",
                    json_agg(
                        json_build_object(
                            a.attribute_name,
                            a.attribute_udt_name
                        )
                    )::json AS \"values\"
                FROM pg_type AS t
                JOIN pg_catalog.pg_namespace AS n ON n.oid = t.typnamespace
                JOIN information_schema.user_defined_types AS u ON u.user_defined_type_name = t.typname
                JOIN information_schema.attributes AS a ON a.udt_name = u.user_defined_type_name
                GROUP BY u.user_defined_type_name
            ) AS sqType
        ";
    }
}
