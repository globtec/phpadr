<?php

namespace ADR\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use ADR\Filesystem\Workspace;
use ADR\Domain\Sequence;
use ADR\Domain\DecisionRecord;
use ADR\Domain\DecisionContent;

/**
 * Command to make ADRs
 * 
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class MakeDecisionCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure()
    {
        $this
            ->setName('make:decision')
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
        $sequence = new Sequence($workspace);
        
        $content = new DecisionContent(
            $sequence->next(),
            $input->getArgument('title')
        );
    
        $workspace->add(new DecisionRecord($content));
        
        $output->writeln('<info>ADR file successfully generated</info>');
    }
}