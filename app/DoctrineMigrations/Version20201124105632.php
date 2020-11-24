<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201124105632 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE RapportSektion ADD virksomhed_detailark_rapport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE RapportSektion ADD CONSTRAINT FK_87A25A23B19DBE6B FOREIGN KEY (virksomhed_detailark_rapport_id) REFERENCES VirksomhedRapport (id)');
        $this->addSql('CREATE INDEX IDX_87A25A23B19DBE6B ON RapportSektion (virksomhed_detailark_rapport_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE RapportSektion DROP FOREIGN KEY FK_87A25A23B19DBE6B');
        $this->addSql('DROP INDEX IDX_87A25A23B19DBE6B ON RapportSektion');
        $this->addSql('ALTER TABLE RapportSektion DROP virksomhed_detailark_rapport_id');
    }
}
