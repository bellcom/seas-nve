<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160229141824 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE BelysningTiltagDetail_ErstatningsLyskilde (id INT AUTO_INCREMENT NOT NULL, arbejde_omfang VARCHAR(255) NOT NULL, antal INT DEFAULT NULL, wattage INT DEFAULT NULL, nyeForkoblinger INT DEFAULT NULL, pris NUMERIC(10, 2) DEFAULT NULL, noter VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE TiltagDetail ADD erstatningsLyskilde_id INT DEFAULT NULL');
    $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CEC3FEB7B2 FOREIGN KEY (erstatningsLyskilde_id) REFERENCES BelysningTiltagDetail_ErstatningsLyskilde (id)');
    $this->addSql('CREATE INDEX IDX_C39D70CEC3FEB7B2 ON TiltagDetail (erstatningsLyskilde_id)');
    $this->addSql('ALTER TABLE TiltagDetail_audit ADD erstatningsLyskilde_id INT DEFAULT NULL');
      
    $this->addSql("
      INSERT INTO BelysningTiltagDetail_ErstatningsLyskilde (id, arbejde_omfang, antal, wattage, nyeForkoblinger, pris, noter)
      VALUES
        (1,'L1-Ledpære 8W E27',1,8,0,50.00,'Erstatter 60W glødepære'),
        (2,'L2-Ledpære 6W E27',1,6,0,50.00,'Erstatter 40W glødepære'),
        (3,'L3-Ledpære 5W GU10',1,5,0,50.00,'Erstatter 35W halogenpære'),
        (4,'L4-Ledpære 3W GU9',1,3,0,50.00,'Erstatter 20W halogenpære'),
        (5,'L5-Ledpære 2W G4',1,2,0,50.00,'Erstatter 10-20W halogenpære'),
        (6,'L6-Ledpære 5W GU5,3',1,5,0,50.00,'Erstatter 35W halogenpære'),
        (7,'L7-LEDpære 25W E27',1,25,0,500.00,'Erstatter 80W kviksølv i udvendig belysning'),
        (8,'L8-LEDrør 9W',1,9,0,80.00,'Erstatter 18W T8 lysstofrør 60cm'),
        (9,'L9-LEDrør 15W',1,15,0,250.00,'Erstatter 30W T8 lysstofrør 90cm'),
        (10,'L10-LEDrør 21W',1,21,0,115.00,'Erstatter 36W T8 lysstofrør 120cm'),
        (11,'L11-LEDrør 24W',1,24,0,150.00,'Erstatter 58W T8 lysstofrør 150cm'),
        (12,'Andet, se noter',NULL,NULL,NULL,0.00,NULL)
    	");
    
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CEC3FEB7B2');
    $this->addSql('DROP TABLE BelysningTiltagDetail_ErstatningsLyskilde');
    $this->addSql('DROP INDEX IDX_C39D70CEC3FEB7B2 ON TiltagDetail');
    $this->addSql('ALTER TABLE TiltagDetail DROP erstatningsLyskilde_id');
    $this->addSql('ALTER TABLE TiltagDetail_audit DROP erstatningsLyskilde_id');
  }
}
