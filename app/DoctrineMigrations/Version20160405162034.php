<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160405162034 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD cashFlow LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Rapport_audit ADD cashFlow LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');

        // Set an empty cash flow.
        $numberOfYears = 30;
        $cashFlow = array(
          'ydelse laan' => array_fill(0, $numberOfYears + 1, 0),
          'laan til faellesomkostninger' => array_fill(0, $numberOfYears + 1, 0),
          'ydelse laan inkl. faellesomkostninger' => array_fill(0, $numberOfYears + 1, 0),
          'besparelse' => array_fill(0, $numberOfYears + 1, 0),
          'cash flow' => array_fill(0, $numberOfYears + 1, 0),
          'akkumuleret' => array_fill(0, $numberOfYears + 1, 0),
        );
        foreach ($cashFlow as &$row) {
          unset($row[0]);
        }

        $this->addSql('UPDATE Rapport SET cashFlow = \'' . serialize($cashFlow) .'\'');
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine')->getManager();

        // Calculate and persist cash flow for all Rapport entities having an empty cash flow.
        $rapporter = $this->container->get('doctrine')->getRepository('AppBundle:Rapport')->findAll();
        foreach ($rapporter as $rapport) {
            $cashFlow = $rapport->getCashFlow();
            if ($cashFlow['cash flow'][1] === 0) {
                $rapport->calculate();
                $sql = 'UPDATE Rapport SET cashFlow = :cashFlow where id = :id';
                $stm = $em->getConnection()->prepare($sql);
                $stm->bindValue('id', $rapport->getId());
                $stm->bindValue('cashFlow', serialize($rapport->getCashFlow()));
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

        $this->addSql('ALTER TABLE Rapport DROP cashFlow');
        $this->addSql('ALTER TABLE Rapport_audit DROP cashFlow');
    }
}
