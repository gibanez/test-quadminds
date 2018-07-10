<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QuadmindsInstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quadminds:install')
            ->setDescription('Crea la base datos si no existe y las tablas necesarias')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $databaseName = $this->getContainer()->getParameter('database_name');

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $sql = sprintf('CREATE DATABASE IF NOT EXISTS %s;', $databaseName);
        $output->writeln("CREANDO BASE DE DATOS: " . $databaseName);
        $output->writeln($sql);
        $prepare = $em->getConnection()->prepare($sql);
        $prepare->execute();

        $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            // ...
        }

        $output->writeln('Command result.' . $databaseName);
    }

}
