<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190930092104 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport ADD besparelseSlutanvendelser LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD besparelseSlutanvendelser LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Rapport ADD besparelseSlutanvendelser LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Rapport_audit ADD besparelseSlutanvendelser LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('UPDATE VirksomhedRapport SET besparelseSlutanvendelser="a:0:{}" WHERE besparelseSlutanvendelser = ""');
        $this->addSql('UPDATE VirksomhedRapport_audit SET besparelseSlutanvendelser="a:0:{}" WHERE besparelseSlutanvendelser = ""');
        $this->addSql('UPDATE Rapport SET besparelseSlutanvendelser="a:0:{}" WHERE besparelseSlutanvendelser = ""');
        $this->addSql('UPDATE Rapport_audit SET besparelseSlutanvendelser="a:0:{}" WHERE besparelseSlutanvendelser = ""');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP besparelseSlutanvendelser');
        $this->addSql('ALTER TABLE Rapport_audit DROP besparelseSlutanvendelser');
        $this->addSql('ALTER TABLE VirksomhedRapport DROP besparelseSlutanvendelser');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP besparelseSlutanvendelser');
    }
}
