<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200519065027 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport DROP Genopretning, DROP genopretningForImplementeringsomkostninger, DROP Modernisering, DROP FravalgtGenopretning, DROP FravalgtModernisering');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP Genopretning, DROP genopretningForImplementeringsomkostninger, DROP Modernisering, DROP FravalgtGenopretning, DROP FravalgtModernisering');
        $this->addSql('ALTER TABLE Tiltag DROP Genopretning, DROP Modernisering, DROP genopretningForImplementeringsomkostninger');
        $this->addSql('ALTER TABLE Tiltag_audit DROP Genopretning, DROP Modernisering, DROP genopretningForImplementeringsomkostninger');
        $this->addSql('ALTER TABLE Rapport DROP Genopretning, DROP Modernisering, DROP FravalgtGenopretning, DROP FravalgtModernisering, DROP genopretningForImplementeringsomkostninger');
        $this->addSql('ALTER TABLE Rapport_audit DROP Genopretning, DROP Modernisering, DROP FravalgtGenopretning, DROP FravalgtModernisering, DROP genopretningForImplementeringsomkostninger');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD Genopretning NUMERIC(10, 0) DEFAULT NULL, ADD Modernisering NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtGenopretning NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtModernisering NUMERIC(10, 0) DEFAULT NULL, ADD genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD Genopretning NUMERIC(10, 0) DEFAULT NULL, ADD Modernisering NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtGenopretning NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtModernisering NUMERIC(10, 0) DEFAULT NULL, ADD genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag ADD Genopretning NUMERIC(10, 0) DEFAULT NULL, ADD Modernisering NUMERIC(10, 0) DEFAULT NULL, ADD genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD Genopretning NUMERIC(10, 0) DEFAULT NULL, ADD Modernisering NUMERIC(10, 0) DEFAULT NULL, ADD genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport ADD Genopretning NUMERIC(10, 0) DEFAULT NULL, ADD genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL, ADD Modernisering NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtGenopretning NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtModernisering NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD Genopretning NUMERIC(10, 0) DEFAULT NULL, ADD genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL, ADD Modernisering NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtGenopretning NUMERIC(10, 0) DEFAULT NULL, ADD FravalgtModernisering NUMERIC(10, 0) DEFAULT NULL');
    }
}
