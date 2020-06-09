<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200609111807 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport ADD nutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD akkumuleretNutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD nutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD akkumuleretNutidsvaerdiSet LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE VirksomhedRapport SET nutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE VirksomhedRapport SET akkumuleretNutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE VirksomhedRapport_audit SET nutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');
        $this->addSql('UPDATE VirksomhedRapport_audit SET akkumuleretNutidsvaerdiSet = "a:0:{}" WHERE 1 = 1');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport DROP nutidsvaerdiSet, DROP akkumuleretNutidsvaerdiSet');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP nutidsvaerdiSet, DROP akkumuleretNutidsvaerdiSet');
    }
}
