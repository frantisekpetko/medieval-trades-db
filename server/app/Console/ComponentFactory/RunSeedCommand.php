<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 23.11.2018
 * Time: 15:40
 */

namespace App\Console\ComponentFactory;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Database\Seeds\MainSeeder;

class RunSeedCommand extends Command
{

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('run:seed')

            // the short description shown while running "php bin/console list"
            ->setDescription('Runs migration and creates all database tables.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create all database tables...')

            // configure an argument
            //->addArgument('seed', InputArgument::REQUIRED, 'The seed of migration.')
            // ...
            //->addArgument('numberOfColumns', InputArgument::REQUIRED, 'The number of columns.')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $seeder = new MainSeeder();
        $seeder->run();
        $output->writeln('Seeds was executed and data was created!');
    }

}