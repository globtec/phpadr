<?php

namespace ADR\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdrCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('adr:create')
            ->setDescription('Creates a new ADR file')
            ->setHelp('This command allows you to create a new ADR file');
    }
}