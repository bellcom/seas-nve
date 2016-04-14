<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160413123036 extends AbstractMigration implements ContainerAwareInterface
{
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

        $this->addSql('ALTER TABLE Tiltag ADD maengde DOUBLE PRECISION DEFAULT NULL, ADD enhed VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD maengde DOUBLE PRECISION DEFAULT NULL, ADD enhed VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        // Calculate and persist "maengde" and "enhed" for each Tiltag.
        $em = $this->container->get('doctrine')->getEntityManager('default');
        $tiltag = $em->getRepository('AppBundle:Tiltag')->findAll();
        if ($tiltag) {
            $sql = 'UPDATE Tiltag set maengde = :maengde, enhed = :enhed WHERE id = :id';
            $stm = $em->getConnection()->prepare($sql);
            foreach ($tiltag as $t) {
                $t->calculate();
                $stm->bindValue('id', $t->getId());
                $stm->bindValue('maengde', $t->getMaengde());
                $stm->bindValue('enhed', $t->getEnhed());
                $stm->execute();
            }
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP maengde, DROP enhed');
        $this->addSql('ALTER TABLE Tiltag_audit DROP maengde, DROP enhed');
    }
}
