<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210205081134 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE Energiforsyning CHANGE navn navn ENUM(\'\',\'fjernvarme\',\'hovedforsyning_el\',\'oliefyr\',\'traepillefyr\',\'varmepumpe\',\'gas\',\'fast_braendsel\') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT \'(DC2Type:NavnType)\';');
        $this->addSql('ALTER TABLE Energiforsyning_audit CHANGE navn navn ENUM(\'\',\'fjernvarme\',\'hovedforsyning_el\',\'oliefyr\',\'traepillefyr\',\'varmepumpe\',\'gas\',\'fast_braendsel\') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT \'(DC2Type:NavnType)\';');
        $this->addSql('UPDATE Energiforsyning SET navn = \'fast_braendsel\', beskrivelse = \'Fast brændsel\'  WHERE beskrivelse = \'Flis\';');
        $this->addSql('UPDATE Energiforsyning_audit SET navn = \'fast_braendsel\', beskrivelse = \'Fast brændsel\'  WHERE beskrivelse = \'Flis\';');
        $this->addSql('UPDATE Energiforsyning SET navn = \'gas\' WHERE beskrivelse = \'Gas\';');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE Energiforsyning CHANGE navn navn ENUM(\'\',\'fjernvarme\',\'hovedforsyning_el\',\'oliefyr\',\'traepillefyr\',\'varmepumpe\',\'gas\',\'flis\') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT \'(DC2Type:NavnType)\';');
        $this->addSql('ALTER TABLE Energiforsyning_audit CHANGE navn navn ENUM(\'\',\'fjernvarme\',\'hovedforsyning_el\',\'oliefyr\',\'traepillefyr\',\'varmepumpe\',\'gas\',\'flis\') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT \'(DC2Type:NavnType)\';');
        $this->addSql('UPDATE Energiforsyning SET navn = \'flis\', beskrivelse = \'Flis\'  WHERE beskrivelse = \'Fast brændsel\';');
        $this->addSql('UPDATE Energiforsyning_audit SET navn = \'flis\', beskrivelse = \'Flis\'  WHERE beskrivelse = \'Fast brændsel\';');
    }
}
