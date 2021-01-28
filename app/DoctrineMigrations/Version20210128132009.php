<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210128132009 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
      $this->addSql('ALTER TABLE Tiltag CHANGE slutanvendelse slutanvendelse ENUM(\'belysning\',\'ventilation\',\'pumper\',\'koeling\',\'trykluft\',\'procesudstyr\',\'varmeanlaeg\',\'klimaskaerm\',\'vinduer\',\'elvarme_rumvarme\',\'elmotorer_intern_transport\',\'energiforbrugende_apparater\',\'oevrige\',\'kedler_udskiftning\',\'kedler_serviceeftersyn\', \'teknisk_isolering\', \'transport\', \'strafafkoeling\') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT \'(DC2Type:SlutanvendelseType)\'; ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
      $this->addSql('ALTER TABLE Tiltag CHANGE slutanvendelse slutanvendelse ENUM(\'belysning\',\'ventilation\',\'pumper\',\'koeling\',\'trykluft\',\'procesudstyr\',\'varmeanlaeg\',\'klimaskaerm\',\'vinduer\',\'elvarme_rumvarme\',\'elmotorer_intern_transport\',\'energiforbrugende_apparater\',\'oevrige\',\'kedler_udskiftning\',\'kedler_serviceeftersyn\') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT \'(DC2Type:SlutanvendelseType)\'; ');
    }
}
