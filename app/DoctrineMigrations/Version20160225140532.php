<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225140532 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD nyStyring_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CE3E55B502 FOREIGN KEY (nyStyring_id) REFERENCES BelysningTiltagDetail_NyStyring (id)');
        $this->addSql('CREATE INDEX IDX_C39D70CE3E55B502 ON TiltagDetail (nyStyring_id)');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD nyStyring_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CE3E55B502');
        $this->addSql('DROP INDEX IDX_C39D70CE3E55B502 ON TiltagDetail');
        $this->addSql('ALTER TABLE TiltagDetail DROP nyStyring_id');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP nyStyring_id');
    }
}
