<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191031132508 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD samletTilskud DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP samletTilskud');
        $this->addSql('ALTER TABLE Rapport_audit DROP samletTilskud');
        $this->addSql('ALTER TABLE VirksomhedRapport DROP samletTilskud');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP samletTilskud');
    }
}
