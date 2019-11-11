<?php

namespace AppBundle\Command;

use AppBundle\DBAL\Types\SlutanvendelseType;
use AppBundle\Entity\Tiltag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SlutanvendelseFixCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('seas-nve:slutanvendelse-fix')
            ->setDescription('Updating Slutanvendelse tiltag values.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $tiltags = $em->getRepository('AppBundle:Tiltag')->findBy(array('slutanvendelse' => NULL));
        $output->writeln(sprintf('Found %s tiltags where slutanvendelse is NULL.', count($tiltags)));

        $to_update = 0;
        /** @var Tiltag $tiltag */
        foreach ($tiltags as $tiltag) {
            if (isset(SlutanvendelseType::$detaultValues[get_class($tiltag)])) {
                $tiltag->setSlutanvendelse(SlutanvendelseType::$detaultValues[get_class($tiltag)]);
                $em->persist($tiltag);
                $to_update++;
            }
        }
        $em->flush();
        if ($to_update) {
            $output->writeln(sprintf('Updated %s tiltags.', $to_update));
        }
    }

}
