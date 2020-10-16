<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyncDataCommand extends Command
{
    protected static $defaultName = 'app:sync-data';

    protected function configure()
    {
        $this->setDescription('Fetch and save data from external API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->getApplication()->find('app:users:fetch')->run($input, $output);
        } catch (\Exception $e) {
            $io->error('Error while running app:users:fetch command.');

            return Command::FAILURE;
        }

        try {
            $this->getApplication()->find('app:posts:fetch')->run($input, $output);
        } catch (\Exception $e) {
            $io->error('Error while running app:posts:fetch command.');

            return Command::FAILURE;
        }

        $io->success('Successfully synced data.');

        return Command::SUCCESS;
    }
}
