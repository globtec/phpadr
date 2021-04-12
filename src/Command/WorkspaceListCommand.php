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
 * Command to list ADRs in workspace
 *
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class WorkspaceListCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('workspace:list')
            ->setDescription('List the ADRs')
            ->setHelp('This command allows you list the ADRs')
            ->addOption(
                'config',
                null,
                InputOption::VALUE_REQUIRED,
                'Config file',
                'vendor/globtec/phpadr/adr.yml'
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
        $workspace = new Workspace($config->directory());

        $records = $workspace->records();

        asort($records);

        if (empty($records)) {
            $output->writeln('<info>Workspace is empty</info>');
        } else {
            $style = new SymfonyStyle($input, $output);
            $style->table(
                ['Filename'],
                array_map(function ($record) {
                    return [$record];
                }, $records)
            );
        }

        return 0;
    }
}