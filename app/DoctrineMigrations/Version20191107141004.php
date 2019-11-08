<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191107141004 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD tIndeMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tIndeDetailed TINYINT(1) DEFAULT NULL, ADD tUdeMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tUdeDetailed TINYINT(1) DEFAULT NULL');
        $this->addSql('UPDATE TiltagDetail SET tIndeMonthly="a:0:{}" WHERE tIndeMonthly = ""');
        $this->addSql('UPDATE TiltagDetail SET tUdeMonthly="a:0:{}" WHERE tUdeMonthly = ""');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD tIndeMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tIndeDetailed TINYINT(1) DEFAULT NULL, ADD tUdeMonthly LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tUdeDetailed TINYINT(1) DEFAULT NULL');
        $this->addSql('UPDATE TiltagDetail_audit SET tIndeMonthly="a:0:{}" WHERE tIndeMonthly = ""');
        $this->addSql('UPDATE TiltagDetail_audit SET tUdeMonthly="a:0:{}" WHERE tUdeMonthly = ""');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP tIndeMonthly, DROP tIndeDetailed, DROP tUdeMonthly, DROP tUdeDetailed');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP tIndeMonthly, DROP tIndeDetailed, DROP tUdeMonthly, DROP tUdeDetailed');
    }
}
