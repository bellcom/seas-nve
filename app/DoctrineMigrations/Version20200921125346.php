<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200921125346 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('UPDATE Tiltag SET co2Override="a:0:{}" WHERE co2Override = ""');
        $this->addSql('UPDATE Tiltag_audit SET co2Override="a:0:{}" WHERE co2Override = ""');
        $this->addSql('UPDATE Tiltag SET priserOverride="a:0:{}" WHERE priserOverride = ""');
        $this->addSql('UPDATE Tiltag_audit SET priserOverride="a:0:{}" WHERE priserOverride = ""');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
