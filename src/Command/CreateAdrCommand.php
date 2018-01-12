<?php

namespace ADR\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use ADR\Filesystem\Workspace;

/**
 * Class of the command line interface to create ADR
 * 
 * @author José Carlos <josecarlos@globtec.com.br>
 */
class CreateAdrCommand extends Command
{
    /**
     * @var Workspace
     */
    private $workspace;
    
    /**
     * @param Workspace $workspace
     */
    public function __construct(Workspace $workspace)
    {
        $this->workspace = $workspace;
        
        parent::__construct();
    }
    
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
        //TODO: Create a new ADR file
        $this->workspace->set($input->getOption('directory'));

        $output->writeln('ADR file successfully generated');
    }
}