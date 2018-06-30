<?php

namespace ADR\Command;

use ADR\Filesystem\Config;
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
        $options = [
            DecisionContent::STATUS_PROPOSED,
            DecisionContent::STATUS_ACCEPTED,
            DecisionContent::STATUS_REJECTED,
            DecisionContent::STATUS_DEPRECATED,
        ];
        
        $this
            ->setName('make:decision')
            ->setDescription('Creates a new ADR')
            ->setHelp('This command allows you to create a new ADR')
            ->addArgument(
                'title',
                InputArgument::REQUIRED,
                'The title of the ADR'
            )
            ->addArgument(
                'status',
                InputArgument::OPTIONAL,
                sprintf(
                   'The status of the ADR, available options: [%s]',
                   implode(', ', $options)
                ),
                DecisionContent::STATUS_ACCEPTED
            )
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
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = new Config($input->getOption('config'));
        $workspace = new Workspace($config->directory());
        $sequence = new Sequence($workspace);
        $content = new DecisionContent($sequence->next(), $input->getArgument('title'), $input->getArgument('status'));
        $record = new DecisionRecord($content, $config);
        
        $workspace->add($record);
        
        $output->writeln('<info>ADR created successfully</info>');
    }
}