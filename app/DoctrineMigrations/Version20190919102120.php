<?php

namespace Application\Migrations;

use AppBundle\Entity\Baseline;
use AppBundle\Entity\BaselineKorrektion;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190919102120 extends AbstractMigration implements ContainerAwareInterface
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

        $this->addSql('ALTER TABLE Bygning DROP FOREIGN KEY FK_FD908E37DC280AA8');
        $this->addSql('DROP INDEX UNIQ_FD908E37DC280AA8 ON Bygning');
        $this->addSql('ALTER TABLE Bygning DROP baseline_id');
        $this->addSql('ALTER TABLE Bygning_audit DROP baseline_id');
        $this->addSql('ALTER TABLE Baseline DROP FOREIGN KEY FK_F6FB1105D371389');
        $this->addSql('DROP INDEX UNIQ_F6FB1105D371389 ON Baseline');
        $this->addSql('ALTER TABLE Baseline DROP bygning_id');
        $this->addSql('ALTER TABLE Baseline ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB110206C32AA FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6FB110206C32AA ON Baseline (virksomhed_id)');
        $this->addSql('ALTER TABLE Baseline_audit DROP bygning_id');
        $this->addSql('ALTER TABLE Baseline_audit ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD baseline_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD CONSTRAINT FK_8B8D3762DC280AA8 FOREIGN KEY (baseline_id) REFERENCES Baseline (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B8D3762DC280AA8 ON Virksomhed (baseline_id)');
    }

    /**
     * @inheritDoc
     */
    public function postUp(Schema $schema)
    {
        $this->cleanup();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP FOREIGN KEY FK_F6FB110206C32AA');
        $this->addSql('DROP INDEX UNIQ_F6FB110206C32AA ON Baseline');
        $this->addSql('ALTER TABLE Baseline DROP virksomhed_id');
        $this->addSql('ALTER TABLE Baseline ADD bygning_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB1105D371389 FOREIGN KEY (bygning_id) REFERENCES Bygning (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6FB1105D371389 ON Baseline (bygning_id)');
        $this->addSql('ALTER TABLE Baseline_audit DROP virksomhed_id');
        $this->addSql('ALTER TABLE Baseline_audit ADD bygning_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning ADD baseline_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning ADD CONSTRAINT FK_FD908E37DC280AA8 FOREIGN KEY (baseline_id) REFERENCES Baseline (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD908E37DC280AA8 ON Bygning (baseline_id)');
        $this->addSql('ALTER TABLE Bygning_audit ADD baseline_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed DROP FOREIGN KEY FK_8B8D3762DC280AA8');
        $this->addSql('DROP INDEX UNIQ_8B8D3762DC280AA8 ON Virksomhed');
        $this->addSql('ALTER TABLE Virksomhed DROP baseline_id');
    }

    /**
     * @inheritDoc
     */
    public function postDown(Schema $schema)
    {
        $this->cleanup();
    }

    /**
     * @inheritDoc
     */
    private function cleanup()
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        $connection = $em->getConnection();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $table = $em->getClassMetadata(Baseline::class)->getTableName();
            $connection->query('DELETE FROM ' . $table);
            $connection->query('TRUNCATE TABLE '  . $table . '_audit');
            $table = $em->getClassMetadata(BaselineKorrektion::class)->getTableName();
            $connection->query('DELETE FROM ' . $table);
            $connection->query('TRUNCATE TABLE '  . $table . '_audit');
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }
    }


}
