<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201030155822 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport ADD forbrugFoer DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerKr DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerCo2 DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD forbrugFoer DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerKr DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerCo2 DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag ADD forbrugFoerKr DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerCo2 DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerVarme NUMERIC(10, 0) DEFAULT NULL, ADD forbrugFoerEl NUMERIC(10, 0) DEFAULT NULL, ADD forbrugFoerBraendstof NUMERIC(10, 0) DEFAULT NULL, CHANGE forbrugFoer forbrugFoer DOUBLE PRECISION DEFAULT NULL, CHANGE forbrugEfter forbrugEfter DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD forbrugFoerKr DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerCo2 DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerVarme NUMERIC(10, 0) DEFAULT NULL, ADD forbrugFoerEl NUMERIC(10, 0) DEFAULT NULL, ADD forbrugFoerBraendstof NUMERIC(10, 0) DEFAULT NULL, CHANGE forbrugFoer forbrugFoer DOUBLE PRECISION DEFAULT NULL, CHANGE forbrugEfter forbrugEfter DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport ADD forbrugFoer DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerKr DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerCo2 DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD forbrugFoer DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerKr DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoerCo2 DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP forbrugFoer, DROP forbrugFoerKr, DROP forbrugFoerCo2');
        $this->addSql('ALTER TABLE Rapport_audit DROP forbrugFoer, DROP forbrugFoerKr, DROP forbrugFoerCo2');
        $this->addSql('ALTER TABLE Tiltag DROP forbrugFoerKr, DROP forbrugFoerCo2, DROP forbrugFoerVarme, DROP forbrugFoerEl, DROP forbrugFoerBraendstof, CHANGE forbrugFoer forbrugFoer INT DEFAULT NULL, CHANGE forbrugEfter forbrugEfter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit DROP forbrugFoerKr, DROP forbrugFoerCo2, DROP forbrugFoerVarme, DROP forbrugFoerEl, DROP forbrugFoerBraendstof, CHANGE forbrugFoer forbrugFoer INT DEFAULT NULL, CHANGE forbrugEfter forbrugEfter INT DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport DROP forbrugFoer, DROP forbrugFoerKr, DROP forbrugFoerCo2');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP forbrugFoer, DROP forbrugFoerKr, DROP forbrugFoerCo2');
    }
}
