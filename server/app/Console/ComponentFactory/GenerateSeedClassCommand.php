<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 22.11.2018
 * Time: 21:10
 */

namespace App\Console\ComponentFactory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSeedClassCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('make:seed')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create a seeding class.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a seeding class...')

            // configure an argument
            ->addArgument('seed', InputArgument::REQUIRED, 'The seed of migration.')
            // ...
            //->addArgument('numberOfColumns', InputArgument::REQUIRED, 'The number of columns.')
        ;

    }

    public function __construct()
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        if(copy( __DIR__ . '/ClassTemplateStore/DummySeeder.stub', __DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub')){

            $str = file_get_contents(__DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub');
            $str = str_replace("use App\Models\DummyModel", "use App\Models\\" . $input->getArgument('seed'), $str);

            //replace something in the file string - this is a VERY simple example
            $str = str_replace("DummySeeder", $input->getArgument('seed') . "Seeder", $str);


            $str = str_replace('$dummy', '$' . $this->formatModelName($input->getArgument('seed')) , $str);
            //$str = str_replace('$dummy', '$' . $this->formatModelName($input->getArgument('seed')) , $str);
            $str = str_replace('DummyModel',  $input->getArgument('seed') , $str);
            //require_once __DIR__ . "/../../Database/Migrations/" . $input->getArgument('model') . "Migration.php";


            $seed =  $input->getArgument('seed');

            $migration = 'App\\Database\\Migrations\\Submigrations\\' . $seed . 'Migration';
            $instance =  new $migration();


            $columnsStr = '$dummy->create([' . "\n";
            $numericOrder = 0;
            $count = count($instance->getFillableColumns());
            $output->writeln("COUNT " . $count);
            foreach($instance->getFillableColumns() as $key => $value){
                if($numericOrder !== $count - 3) {
                    $output->writeln('Normal column!');
                    if ($key !== "id" && $key !== "created_at" && $key !== "updated_at")
                    {
                        $columnsStr.= "         ". "'"."$key" ."'" . "  => '',\n";
                    }



                }
                else {
                    if ($key !== "id" && $key !== "created_at" && $key !== "updated_at")
                    {
                        $columnsStr.= "         ". "'". $key ."'" . "  => ''\n        ]);";
                    }
                    $output->writeln('Ending column!');
                    $output->writeln($columnsStr);
                }
                $numericOrder++;
            }

            $search = '$product->create([ ])->finish();';

            $str = str_replace($search,  $search . $columnsStr,   $str);
            $str = str_replace($search,  '',   $str);
            $output->writeln($str);
            //write the entire string
            $str = str_replace('$dummy', '$' . $this->formatModelName($input->getArgument('seed')) , $str);
            file_put_contents(__DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub', $str);

            rename(__DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub',  __DIR__ . '/../../Database/Seeds/Subseeds/'. $input->getArgument('seed'). 'Seeder.php');

            $output->writeln('Migration was successfully created!');

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