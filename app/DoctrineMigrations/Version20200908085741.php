<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200908085741 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag CHANGE priserOverride priserOverride LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE co2Override co2Override LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Configuration ADD varmeEnergiCo2 LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Configuration_audit ADD varmeEnergiCo2 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE Configuration SET varmeEnergiCo2="a:0:{}" WHERE varmeEnergiCo2 = ""');
        $this->addSql('UPDATE Configuration_audit SET varmeEnergiCo2="a:0:{}" WHERE varmeEnergiCo2 = ""');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration DROP varmeEnergiCo2');
        $this->addSql('ALTER TABLE Configuration_audit DROP varmeEnergiCo2');
        $this->addSql('ALTER TABLE Tiltag CHANGE priserOverride priserOverride LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE co2Override co2Override LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\'');
    }
}
