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
        $this->addSql('UPDATE Configuration SET tOpvarmningTimerAarMonthly="a:0:{}" WHERE tOpvarmningTimerAarMonthly = ""');
        $this->addSql('UPDATE Configuration SET tJordMonthly="a:0:{}" WHERE tJordMonthly = ""');
        $this->addSql('UPDATE Configuration SET tUdeMonthly="a:0:{}" WHERE tUdeMonthly = ""');
        $this->addSql('ALTER TABLE Configuration_audit ADD tOpvarmningTimerAarMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tJordMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tUdeMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE Configuration_audit SET tOpvarmningTimerAarMonthly="a:0:{}" WHERE tOpvarmningTimerAarMonthly = ""');
        $this->addSql('UPDATE Configuration_audit SET tJordMonthly="a:0:{}" WHERE tJordMonthly = ""');
        $this->addSql('UPDATE Configuration_audit SET tUdeMonthly="a:0:{}" WHERE tUdeMonthly = ""');    }

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
