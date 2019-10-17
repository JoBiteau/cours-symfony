<?php

namespace App\Command;

use App\Entity\Ville;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class Ex1CleanCommand extends Command
{
    protected static $defaultName = 'ex1:clean';
    protected $entityManager;

    /**
     * Ex1HydrateCommand constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct (EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }


    protected function configure()
    {
        $this
            ->setDescription('Vider la base de donnée')
        ;
    }



    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $em = $this->entityManager;

        $em->getConnection()->query('TRUNCATE ville ')->execute();
        $em->getConnection()->query('TRUNCATE user ')->execute();


        $io->success('Base de données vidée ! ! !.');
    }
}
