<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191108103918 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration ADD tOpvarmningTimerAarMonthly LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD tJordMonthly LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD tUdeMonthly LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $tOpvarmningTimerAarMonthly = 'a:12:{s:6:"januar";s:3:"744";s:7:"februar";s:3:"672";s:5:"marts";s:3:"744";s:5:"april";s:3:"720";s:3:"maj";s:3:"744";s:4:"juni";s:3:"720";s:4:"juli";s:3:"744";s:6:"august";s:3:"744";s:9:"september";s:3:"720";s:7:"oktober";s:3:"744";s:8:"november";s:3:"720";s:8:"december";s:3:"744";}';
        $tOpvarmningTimerAarMonthly = str_replace('"', '\\"', $tOpvarmningTimerAarMonthly);
        $tJordMonthly = 'a:12:{s:6:"januar";s:1:"8";s:7:"februar";s:1:"8";s:5:"marts";s:1:"8";s:5:"april";s:1:"8";s:3:"maj";s:1:"8";s:4:"juni";s:1:"8";s:4:"juli";s:1:"8";s:6:"august";s:1:"8";s:9:"september";s:1:"8";s:7:"oktober";s:1:"8";s:8:"november";s:1:"8";s:8:"december";s:1:"8";}';
        $tJordMonthly = str_replace('"', '\\"', $tJordMonthly);
        $tUdeMonthly = 'a:12:{s:6:"januar";s:1:"0";s:7:"februar";s:1:"0";s:5:"marts";s:3:"2.1";s:5:"april";s:3:"5.7";s:3:"maj";s:4:"10.8";s:4:"juni";s:4:"14.3";s:4:"juli";s:4:"15.6";s:6:"august";s:4:"15.7";s:9:"september";s:4:"12.7";s:7:"oktober";s:3:"9.1";s:8:"november";s:3:"4.7";s:8:"december";s:3:"1.6";}';
        $tUdeMonthly = str_replace('"', '\\"', $tUdeMonthly);
        $this->addSql('UPDATE Configuration SET tOpvarmningTimerAarMonthly="' . $tOpvarmningTimerAarMonthly . '" WHERE tOpvarmningTimerAarMonthly = ""');
        $this->addSql('UPDATE Configuration SET tJordMonthly="' . $tJordMonthly . '" WHERE tJordMonthly = ""');
        $this->addSql('UPDATE Configuration SET tUdeMonthly="' . $tUdeMonthly . '" WHERE tUdeMonthly = ""');
        $this->addSql('ALTER TABLE Configuration_audit ADD tOpvarmningTimerAarMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tJordMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tUdeMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE Configuration_audit SET tOpvarmningTimerAarMonthly="' . $tOpvarmningTimerAarMonthly . '" WHERE tOpvarmningTimerAarMonthly = ""');
        $this->addSql('UPDATE Configuration_audit SET tJordMonthly="' . $tJordMonthly . '" WHERE tJordMonthly = ""');
        $this->addSql('UPDATE Configuration_audit SET tUdeMonthly="' . $tUdeMonthly . '" WHERE tUdeMonthly = ""');    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration DROP tOpvarmningTimerAarMonthly, DROP tJordMonthly, DROP tUdeMonthly');
        $this->addSql('ALTER TABLE Configuration_audit DROP tOpvarmningTimerAarMonthly, DROP tJordMonthly, DROP tUdeMonthly');
    }
}
