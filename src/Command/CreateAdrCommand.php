<?php

namespace ADR\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdrCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('make:skeleton')
            ->setDescription('Creates a new ADR file')
            ->setHelp('This command allows you to create a new ADR file')
            ->addArgument('title', InputArgument::REQUIRED, 'The title of the ADR');
    }

    /**
     * Execute the command
     * 
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO: Create a new ADR file

        $output->writeln('ADR file successfully generated');
    }
}