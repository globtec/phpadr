<?php

namespace ADR\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ADR\Filesystem\Workspace;

/**
 * Command to count ADRs in workspace
 * 
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class WorkspaceCountCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('workspace:count')
            ->setDescription('Count the ADRs')
            ->setHelp('This command allows you count the ADRs')
            ->addOption(
                'directory',
                null,
                InputOption::VALUE_REQUIRED,
                'Workspace that store the ADRs',
                'docs/arch'
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
        $workspace = new Workspace($input->getOption('directory'));
        
        $output->writeln(sprintf('<info>%d ADRs</info>', $workspace->count()));
    }
}