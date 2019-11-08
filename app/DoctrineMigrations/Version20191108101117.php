<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191108101117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD tOpvarmningTimerAarMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE TiltagDetail SET tOpvarmningTimerAarMonthly="a:0:{}" WHERE tOpvarmningTimerAarMonthly = ""');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD tOpvarmningTimerAarMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE TiltagDetail_audit SET tOpvarmningTimerAarMonthly="a:0:{}" WHERE tOpvarmningTimerAarMonthly = ""');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP tOpvarmningTimerAarMonthly');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP tOpvarmningTimerAarMonthly');
    }
}
