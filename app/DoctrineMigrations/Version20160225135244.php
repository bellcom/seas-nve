<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225135244 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE BelysningTiltagDetail_Styring CHANGE name titel VARCHAR(255) NOT NULL');

    $this->addSql("INSERT INTO BelysningTiltagDetail_Styring (id, titel, pris, noter) VALUES
                      (1,'S1-Tilstedeværelsessensor påbyg på loft med lux føler (on/off)',1750,'Inklusiv montering som synlig installation eller ved nedsænket loft.'),
                      (2,'S2-Tilstedeværelsessensor påbyg 2-kanal med lux føler (on/off)',2240,'Inklusiv montering som synlig installation eller ved nedsænket loft.'),
                      (3,'S3-Tilstedeværelsessensor påbyg på loft med kontinuerlig dagslysstyring, dæmp og DALI',2940,'Inklusiv montering som synlig installation eller ved nedsænket loft.'),
                      (4,'S4-Etablering af tryk i eksisterende dåse for tænd/sluk og dæmp af lys',260,'Inklusiv montering  og ramme.'),
                      (5,'S5-Etablering af ny synlig installation af tryk for tænd/sluk og dæmp af lys.',535,'Inklusiv montering som synlig installation . (ramme, underlag og 2 m kanal.)'),
                      (6,'S6-Etablering af svagstrøms tryk med 4 slutte tryk, i eksisterende kontakt for tænd/sluk og dæmp af lys.',365,'Inklusiv montering og ramme.'),
                      (7,'S7-Etablering af ny synlig installation af svagstrøms tryk med 4 slutte tryk, for tænd/sluk og dæmp af lys',635,'Inklusiv montering som synlig installation. (ramme, underlag og 2 m kanal.)'),
                      (8,'S8-Bevægelsessensor i stedet for eksisterende afbryder 180 grader',790,'Inklusiv montering'),
                      (9,'S9-Astronomisk ur ',2040,'Til indbygninng i eksisterende tavler for styring af det udvendige lys.'),
                      (10,'S10-Andet, se noter',0,NULL)");
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE BelysningTiltagDetail_Styring CHANGE titel name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
  }
}
