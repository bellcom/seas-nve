<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151214151708 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE NyttiggjortVarme (id INT AUTO_INCREMENT NOT NULL, faktor DOUBLE PRECISION NOT NULL, titel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('CREATE TABLE NyttiggjortVarme_audit (id INT NOT NULL, rev INT NOT NULL, faktor DOUBLE PRECISION DEFAULT NULL, titel VARCHAR(255) DEFAULT NULL, revtype VARCHAR(4) NOT NULL, PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('DROP TABLE BygningStatus');
    $this->addSql('ALTER TABLE TiltagDetail ADD nyttiggjortvarme_id INT DEFAULT NULL');
    $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CED518EA9 FOREIGN KEY (nyttiggjortvarme_id) REFERENCES NyttiggjortVarme (id)');
    $this->addSql('CREATE INDEX IDX_C39D70CED518EA9 ON TiltagDetail (nyttiggjortvarme_id)');
    $this->addSql('ALTER TABLE TiltagDetail_audit ADD nyttiggjortvarme_id INT DEFAULT NULL, DROP nyttiggjortVarme');

    $this->addSql(
      "LOCK TABLES `NyttiggjortVarme` WRITE;

          INSERT INTO `NyttiggjortVarme` (`id`, `faktor`, `titel`)
          VALUES
            (1,0.1,'Opvarmede opholdsrum'),
            (2,0.5,'Depotrum'),
            (3,0.5,'Opvarmet teknikrum'),
            (4,0.8,'Uopvarmet teknikrum'),
            (5,1,'Tag og skunkrum'),
            (6,1,'Garager og udhuse'),
            (7,1,'Udeliggende trappeopgange'),
            (8,1,'Rør i jord');

          UNLOCK TABLES;"
    );

    $this->addSql('UPDATE TiltagDetail td LEFT JOIN NyttiggjortVarme nv ON td.nyttiggjortVarme = nv.faktor SET td.nyttiggjortvarme_id = nv.id');
    $this->addSql('ALTER TABLE TiltagDetail DROP nyttiggjortVarme');
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CED518EA9');
    $this->addSql('CREATE TABLE BygningStatus (id INT AUTO_INCREMENT NOT NULL, navn VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('DROP TABLE NyttiggjortVarme');
    $this->addSql('DROP TABLE NyttiggjortVarme_audit');
    $this->addSql('DROP INDEX IDX_C39D70CED518EA9 ON TiltagDetail');
    $this->addSql('ALTER TABLE TiltagDetail ADD nyttiggjortVarme NUMERIC(10, 4) DEFAULT NULL, DROP nyttiggjortvarme_id');
    $this->addSql('ALTER TABLE TiltagDetail_audit ADD nyttiggjortVarme NUMERIC(10, 4) DEFAULT NULL, DROP nyttiggjortvarme_id');
  }
}
