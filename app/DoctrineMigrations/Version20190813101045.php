<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190813101045 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Virksomhed ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD CONSTRAINT FK_8B8D3762727ACA70 FOREIGN KEY (parent_id) REFERENCES Virksomhed (id)');
        $this->addSql('CREATE INDEX IDX_8B8D3762727ACA70 ON Virksomhed (parent_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Virksomhed DROP FOREIGN KEY FK_8B8D3762727ACA70');
        $this->addSql('DROP INDEX IDX_8B8D3762727ACA70 ON Virksomhed');
        $this->addSql('ALTER TABLE Virksomhed DROP parent_id');
    }
}
