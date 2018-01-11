<?php

namespace ADR\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class CreateAdrCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('make:skeleton')
            ->setDescription('Creates a new ADR')
            ->setHelp('This command allows you to create a new ADR')
            ->addArgument(
                'title',
                InputArgument::REQUIRED,
                'The title of the ADR'
            )
            ->addOption(
                'directory',
                null,
                InputOption::VALUE_REQUIRED,
                'Workspace that store the ADRs',
                'docs'
            );
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