<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190903055253 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD besparelseCo2BraendstofITon NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD besparelseCo2BraendstofITon NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport ADD co2BesparelseBraendstofITon DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD co2BesparelseBraendstofITon DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP co2BesparelseBraendstofITon');
        $this->addSql('ALTER TABLE Rapport_audit DROP co2BesparelseBraendstofITon');
        $this->addSql('ALTER TABLE Tiltag DROP besparelseCo2BraendstofITon');
        $this->addSql('ALTER TABLE Tiltag_audit DROP besparelseCo2BraendstofITon');
    }
}
