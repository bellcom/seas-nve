<?php

namespace Application\Migrations;

use AppBundle\Entity\Configuration;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191111095002 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(sprintf('# Set default configuration values.'));
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        /** @var Configuration $configuration */
        $configuration = $em->getRepository(Configuration::class)->getConfiguration();
        $configuration->setTJordMonthly(array(
            'januar' => '8',
            'februar' => '8',
            'marts' => '8',
            'april' => '8',
            'maj' => '8',
            'juni' => '8',
            'juli' => '8',
            'august' => '8',
            'september' => '8',
            'oktober' => '8',
            'november' => '8',
            'december' => '8',
        ));
        $configuration->setTUdeMonthly(array(
            'januar' => '0',
            'februar' => '0',
            'marts' => '2.1',
            'april' => '5.7',
            'maj' => '10.8',
            'juni' => '14.3',
            'juli' => '15.6',
            'august' => '15.7',
            'september' => '12.7',
            'oktober' => '9.1',
            'november' => '4.7',
            'december' => '1.6',
        ));
        $configuration->setTOpvarmningTimerAarMonthly(array(
            'januar' => '744',
            'februar' => '672',
            'marts' => '744',
            'april' => '720',
            'maj' => '744',
            'juni' => '720',
            'juli' => '744',
            'august' => '744',
            'september' => '720',
            'oktober' => '744',
            'november' => '720',
            'december' => '744',
        ));
        $em->persist($configuration);
        $em->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(sprintf('# No actions to down.'));
    }
}
