<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201123131325 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE RapportSektion ADD virksomhed_screening_rapport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE RapportSektion ADD CONSTRAINT FK_87A25A2347FD0D4B FOREIGN KEY (virksomhed_screening_rapport_id) REFERENCES VirksomhedRapport (id)');
        $this->addSql('CREATE INDEX IDX_87A25A2347FD0D4B ON RapportSektion (virksomhed_screening_rapport_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE RapportSektion DROP FOREIGN KEY FK_87A25A2347FD0D4B');
        $this->addSql('DROP INDEX IDX_87A25A2347FD0D4B ON RapportSektion');
        $this->addSql('ALTER TABLE RapportSektion DROP virksomhed_screening_rapport_id');
    }
}
