<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160226131517 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CE8FB26026');
        $this->addSql('DROP INDEX idx_c39d70ce8fb26026 ON TiltagDetail');
        $this->addSql('CREATE INDEX IDX_C39D70CE3CCC2BD3 ON TiltagDetail (nytArmatur_id)');
        $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CE8FB26026 FOREIGN KEY (NytArmatur_id) REFERENCES BelysningTiltagDetail_NytArmatur (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CE3CCC2BD3');
        $this->addSql('DROP INDEX idx_c39d70ce3ccc2bd3 ON TiltagDetail');
        $this->addSql('CREATE INDEX IDX_C39D70CE8FB26026 ON TiltagDetail (NytArmatur_id)');
        $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CE3CCC2BD3 FOREIGN KEY (nytArmatur_id) REFERENCES BelysningTiltagDetail_NytArmatur (id)');
    }
}
