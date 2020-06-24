<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200623072952 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CE85DBA8D5');
        $this->addSql('DROP TABLE PumpeTiltagDetailApplikation');
        $this->addSql('DROP INDEX IDX_C39D70CE85DBA8D5 ON TiltagDetail');
        $this->addSql('ALTER TABLE TiltagDetail DROP applikation_id');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP applikation_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE PumpeTiltagDetailApplikation (id INT AUTO_INCREMENT NOT NULL, navn VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE TiltagDetail ADD applikation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CE85DBA8D5 FOREIGN KEY (applikation_id) REFERENCES PumpeTiltagDetailApplikation (id)');
        $this->addSql('CREATE INDEX IDX_C39D70CE85DBA8D5 ON TiltagDetail (applikation_id)');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD applikation_id INT DEFAULT NULL');
    }
}
