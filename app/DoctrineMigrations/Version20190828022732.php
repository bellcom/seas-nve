<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190828022732 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD tilskudsstoerrelse DOUBLE PRECISION DEFAULT NULL, ADD besparelseInvestering NUMERIC(14, 4) DEFAULT NULL, ADD besparelseVedligehold NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD tilskudsstoerrelse DOUBLE PRECISION DEFAULT NULL, ADD besparelseInvestering NUMERIC(14, 4) DEFAULT NULL, ADD besparelseVedligehold NUMERIC(14, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP tilskudsstoerrelse, DROP besparelseInvestering, DROP besparelseVedligehold');
        $this->addSql('ALTER TABLE Tiltag_audit DROP tilskudsstoerrelse, DROP besparelseInvestering, DROP besparelseVedligehold');
    }
}
