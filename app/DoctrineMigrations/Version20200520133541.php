<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200520133541 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COMMENT \'(DC2Type:StyringType)\'');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COMMENT \'(DC2Type:StyringType)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP styring');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP styring');
    }
}
