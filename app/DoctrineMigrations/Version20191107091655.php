<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191107091655 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD graddageFordeling INT DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CE9C2BB8B4 FOREIGN KEY (graddageFordeling) REFERENCES GraddageFordeling (id)');
        $this->addSql('CREATE INDEX IDX_C39D70CE9C2BB8B4 ON TiltagDetail (graddageFordeling)');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD graddageFordeling INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CE9C2BB8B4');
        $this->addSql('DROP INDEX IDX_C39D70CE9C2BB8B4 ON TiltagDetail');
        $this->addSql('ALTER TABLE TiltagDetail DROP graddageFordeling');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP graddageFordeling');
    }
}
