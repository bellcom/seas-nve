<?php

namespace Application\Migrations;

use AppBundle\DBAL\Types\SlutanvendelseType;
use AppBundle\Entity\Tiltag;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191009085100 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // Do not show warning on migrations.
        $this->addSql('# Updating Tiltags slutanvendelse with default values');

        $em = $this->container->get('doctrine.orm.entity_manager');
        $tiltags = $em->getRepository('AppBundle:Tiltag')->findBy(array('slutanvendelse' => NULL));
        $this->addSql(sprintf('# Found %s tiltags where slutanvendelse is NULL.', count($tiltags)));

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
          $this->addSql(sprintf('# Updated %s tiltags.', $to_update));
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // Do not show warning on migrations.
        $this->addSql('# This migration doesn\'t have down sql commands.');
    }
}
