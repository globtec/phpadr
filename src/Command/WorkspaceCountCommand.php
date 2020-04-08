<?php

namespace ADR\Command;

use ADR\Filesystem\Config;
use ADR\Filesystem\Workspace;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
                'config',
                null,
                InputOption::VALUE_REQUIRED,
                'Config file',
                'adr.yml'
            );
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = new Config($input->getOption('config'));
        $style = new SymfonyStyle($input, $output);
        $workspace = new Workspace($config->directory());

        $style->table(['Count'], [[$workspace->count()]]);

        return 0;
    }
}