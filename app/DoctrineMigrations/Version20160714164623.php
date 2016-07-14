<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160714164623 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Komponent (id INT AUTO_INCREMENT NOT NULL, titel VARCHAR(255) NOT NULL, roerlaengde NUMERIC(10, 4) NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE TiltagDetail ADD komponent_id INT DEFAULT NULL, DROP tankVolL');
        $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CEE4A7D901 FOREIGN KEY (komponent_id) REFERENCES Komponent (id)');
        $this->addSql('CREATE INDEX IDX_C39D70CEE4A7D901 ON TiltagDetail (komponent_id)');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD komponent_id INT DEFAULT NULL, DROP tankVolL');

        $this->addSql("INSERT INTO Komponent (titel, roerlaengde) VALUES ('Lille ventil', 0.2), ('Middel ventil', 0.5), ('Stor ventil', 1), ('Stor ventil m. flange', 1.5), ('Pumpe', 2), ('Uisol. Bolteflange < 3”', 0.33), ('Uisol. Bolteflange > 3”', 0.5)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CEE4A7D901');
        $this->addSql('DROP TABLE Komponent');
        $this->addSql('DROP INDEX IDX_C39D70CEE4A7D901 ON TiltagDetail');
        $this->addSql('ALTER TABLE TiltagDetail ADD tankVolL NUMERIC(10, 4) DEFAULT NULL, DROP komponent_id');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD tankVolL NUMERIC(10, 4) DEFAULT NULL, DROP komponent_id');
    }
}
