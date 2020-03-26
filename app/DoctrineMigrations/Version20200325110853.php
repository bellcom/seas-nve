<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200325110853 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD trykLuftIndData LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD trykLuftElForbrug LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD trykLuftElReduktion LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD trykLuftVarmeReduktion LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD trykLuftIndData LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD trykLuftElForbrug LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD trykLuftElReduktion LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD trykLuftVarmeReduktion LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP trykLuftIndData, DROP trykLuftElForbrug, DROP trykLuftElReduktion, DROP trykLuftVarmeReduktion');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP trykLuftIndData, DROP trykLuftElForbrug, DROP trykLuftElReduktion, DROP trykLuftVarmeReduktion');
    }
}
