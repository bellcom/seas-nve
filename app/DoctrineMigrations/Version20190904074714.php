<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190904074714 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ContactPerson DROP FOREIGN KEY FK_271C63269D62CEA9');
        $this->addSql('DROP INDEX IDX_271C63269D62CEA9 ON ContactPerson');
        $this->addSql('ALTER TABLE ContactPerson ADD reference_type ENUM(\'virksomhed\', \'bygning\') NOT NULL COMMENT \'(DC2Type:ContactPersonReferenceType)\', CHANGE virksomhed_id reference_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ContactPerson DROP reference_type, CHANGE reference_id virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ContactPerson ADD CONSTRAINT FK_271C63269D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('CREATE INDEX IDX_271C63269D62CEA9 ON ContactPerson (virksomhed_id)');
    }
}
