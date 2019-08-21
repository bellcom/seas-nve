<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190821070429 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD slutanvendelse ENUM(\'screening\', \'undeseogelse\', \'emo\', \'energiledelse\', \'energisyn\') DEFAULT NULL COMMENT \'(DC2Type:SlutanvendelseType)\'');
        $this->addSql('ALTER TABLE Tiltag_audit ADD slutanvendelse ENUM(\'screening\', \'undeseogelse\', \'emo\', \'energiledelse\', \'energisyn\') DEFAULT NULL COMMENT \'(DC2Type:SlutanvendelseType)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP slutanvendelse');
        $this->addSql('ALTER TABLE Tiltag_audit DROP slutanvendelse');
    }
}
