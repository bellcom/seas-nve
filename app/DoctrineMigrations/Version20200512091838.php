<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200512091838 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail CHANGE levetidAar levetidAar ENUM(\'\', \'5\', \'10\', \'15\', \'20\', \'25\', \'30\', \'40\') DEFAULT NULL COMMENT \'(DC2Type:LevetidType)\'');
        $this->addSql('ALTER TABLE TiltagDetail_audit CHANGE levetidAar levetidAar ENUM(\'\', \'5\', \'10\', \'15\', \'20\', \'25\', \'30\', \'40\') DEFAULT NULL COMMENT \'(DC2Type:LevetidType)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail CHANGE levetidAar levetidAar INT DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit CHANGE levetidAar levetidAar INT DEFAULT NULL');
    }
}
