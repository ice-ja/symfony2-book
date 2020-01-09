<?php
namespace App\Command;

use App\Entity\Concert;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cs:test')
            ->setDescription('test')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine')->getManager();
        $repository = $em->getRepository(Concert::class);
        $concertList = $repository->findAll();

        $serializer = $container->get('jms_serializer');
        $json = $serializer->serialize($concertList, 'json');

        dump($json);
    }
}
