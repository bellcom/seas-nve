<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200518142945 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP primaerEnterprise');
        $this->addSql('ALTER TABLE Tiltag_audit DROP primaerEnterprise');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD primaerEnterprise ENUM(\'\', \'el\', \'t/i\', \'ve\', \'vvs\', \'hh\', \'a\', \'ia\', \'t\') NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:PrimaerEnterpriseType)\'');
        $this->addSql('ALTER TABLE Tiltag_audit ADD primaerEnterprise ENUM(\'\', \'el\', \'t/i\', \'ve\', \'vvs\', \'hh\', \'a\', \'ia\', \'t\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:PrimaerEnterpriseType)\'');
    }
}
