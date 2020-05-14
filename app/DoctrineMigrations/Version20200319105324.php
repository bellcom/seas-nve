<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200319105324 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration ADD grundventilationMatrix LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD udeluftTilfoerselMatrix LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Configuration_audit ADD grundventilationMatrix LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD udeluftTilfoerselMatrix LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE Configuration SET grundventilationMatrix="a:0:{}" WHERE grundventilationMatrix = ""');
        $this->addSql('UPDATE Configuration SET udeluftTilfoerselMatrix="a:0:{}" WHERE udeluftTilfoerselMatrix = ""');
        $this->addSql('UPDATE Configuration_audit SET grundventilationMatrix="a:0:{}" WHERE grundventilationMatrix = ""');
        $this->addSql('UPDATE Configuration_audit SET udeluftTilfoerselMatrix="a:0:{}" WHERE udeluftTilfoerselMatrix = ""');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration DROP grundventilationMatrix, DROP udeluftTilfoerselMatrix');
        $this->addSql('ALTER TABLE Configuration_audit DROP grundventilationMatrix, DROP udeluftTilfoerselMatrix');
    }
}
