<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 21.10.2018
 * Time: 16:03
 */

namespace App\Console;

use App\Database\DB;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCleanDatabaseCommand extends Command
{
    private $db;


    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('db:clean')

            // the short description shown while running "php bin/console list"
            ->setDescription('Clean database and delete all tables.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to clean database..')
        ;
    }

    public function __construct()
    {
        $this->db = DB::schema();
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stm = $this->db->query("SELECT * FROM sqlite_master");
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        $tables[] = $result;

        $output->writeln(var_dump($tables));
        $this->db->exec("BEGIN");


        foreach($tables as $tableName) {
            $output->writeln("TABLE " . $tableName["tbl_name"]);
            $tableName["tbl_name"] === "sqlite_sequence" ?  null : $this->db->exec(sprintf('DROP TABLE %s', $tableName["tbl_name"]));
        }

        $this->db->exec("COMMIT");

        $output->writeln('Database was cleaned succcessfully!');
    }
}