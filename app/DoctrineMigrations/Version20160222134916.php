<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160222134916 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD BaselineCO2El DOUBLE PRECISION DEFAULT NULL, ADD BaselineCO2Varme DOUBLE PRECISION DEFAULT NULL, ADD BaselineCO2Samlet DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD BaselineCO2El DOUBLE PRECISION DEFAULT NULL, ADD BaselineCO2Varme DOUBLE PRECISION DEFAULT NULL, ADD BaselineCO2Samlet DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP BaselineCO2El, DROP BaselineCO2Varme, DROP BaselineCO2Samlet');
        $this->addSql('ALTER TABLE Rapport_audit DROP BaselineCO2El, DROP BaselineCO2Varme, DROP BaselineCO2Samlet');
    }
}
