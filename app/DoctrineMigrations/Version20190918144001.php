<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190918144001 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE VirksomhedKortlaegning (id INT AUTO_INCREMENT NOT NULL, virksomhed_id INT DEFAULT NULL, titel VARCHAR(255) NOT NULL, total_forbrug DOUBLE PRECISION DEFAULT NULL, slutanvendelser LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', aar VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F9C1C5649D62CEA9 (virksomhed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VirksomhedKortlaegning ADD CONSTRAINT FK_F9C1C5649D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('ALTER TABLE Virksomhed ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD CONSTRAINT FK_8B8D37629D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES VirksomhedKortlaegning (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8B8D37629D62CEA9 ON Virksomhed (virksomhed_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Virksomhed DROP FOREIGN KEY FK_8B8D37629D62CEA9');
        $this->addSql('DROP TABLE VirksomhedKortlaegning');
        $this->addSql('DROP INDEX UNIQ_8B8D37629D62CEA9 ON Virksomhed');
        $this->addSql('ALTER TABLE Virksomhed DROP virksomhed_id');
    }
}
