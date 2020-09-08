<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 21.10.2018
 * Time: 17:09
 */

namespace App\Console\ComponentFactory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class GenerateMigrationClassCommand extends Command
{


    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('make:migration')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a migration class.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a migration class...')

            // configure an argument
            ->addArgument('migration', InputArgument::REQUIRED, 'The name of migration.')
            // ...
            ->addArgument('numberOfColumns', InputArgument::REQUIRED, 'The number of columns.')
        ;

    }

    public function __construct()
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->command($input->getArgument('migration'), $input->getArgument('numberOfColumns'));
        $output->writeln('Migration was successfully created!');
    }

    public function command(string $model, $count)
    {
        if(copy( __DIR__ . '/ClassTemplateStore/DummyMigration.stub', __DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub')){

            $str = file_get_contents(__DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub');

            //replace something in the file string - this is a VERY simple example
            $str = str_replace("DummyMigration", $model . "Migration", $str);

            //strcspn('aAple', 'ABCDEFGHJIJKLMNOPQRSTUVWXYZ');
            $str = str_replace("dummymodel", $this->formatModelName($model) , $str);
            //require_once __DIR__ . "/../../Database/Migrations/" . $input->getArgument('model') . "Migration.php";

            /*
            $model =  $input->getArgument('model');
            $migration = 'App\\Database\\Migrations\\' . $model . 'Migration';
            $instance =  new $migration();
            */

            $columnsStr = 'protected $fillable = [' . "\n";
            $numericOrder = 0;

            for($i = 0; $i < $count + 1 ; $i++){
                if($numericOrder === 0) {
                    $columnsStr.= "         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',\n";

                }
                else {
                    $columnsStr.= "         ''  =>  '',\n";
                }

                $numericOrder++;
            }

            $columnsStr.= "         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',\n";
            $columnsStr.= "         'updated_at' => 'DATETIME'\n    ];";

            $search = 'protected $columns = [];';

            $str = str_replace($search,  $search . $columnsStr,   $str);
            $str = str_replace($search,  '',   $str);
            //$output->writeln($str);
            //write the entire string
            file_put_contents(__DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub', $str);

            rename(__DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub',  __DIR__ . '/../../Database/Migrations/Submigrations/'. $model. 'Migration.php');

        }
    }

    private function formatModelName($str):string{

        $count = strlen($str);

        $i = 0;
        $ii = 0;
        $strarr  = str_split($str);
        while($i < $count)
        {
            $char = $strarr{$i};
            if(preg_match("[A-Z]", $char, $val)){
                $ii++;
                $str[$ii] = $strarr[$ii]  . $char;
            } else {
                $str[$ii] = $strarr[$ii]  . $char;
            }
            $i++;
        }

        $l = 0;
        $position  = 0;

        foreach ($strarr as $letter) {
            $letter === strtoupper($letter) ?  $position = $l : null;
            $l++;
        }

        /*
        * zkontrolování jestli proměnná position není hodnoty 0, pokud ano, tak to znamená že předcházející foreach
        * zjistil zaznamenal jen jedno velké písmeno
        */

        $position !== 0 ? array_splice($strarr, $position , 0, "_" ) : null;

        $newStr = null;

        foreach ($strarr as $letter) {
            $newStr.= $letter;
        }

        return strtolower($newStr);

    }

}