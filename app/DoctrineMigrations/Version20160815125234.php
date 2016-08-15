<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160815125234 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline CHANGE arealdataSekundaerKilde arealdataSekundaerKilde ENUM(\'ingen_sekundaer_kilde_vurderes_noedvendig\', \'caretaker\', \'tegningsfiler_i_kontainer\', \'bbr_meddelelse\', \'bygningskonsulent_ved_aak\', \'mark_kontrol\') DEFAULT NULL COMMENT \'(DC2Type:ArealKildeSekundaerType)\'');
        $this->addSql('ALTER TABLE Baseline_audit CHANGE arealdataSekundaerKilde arealdataSekundaerKilde ENUM(\'ingen_sekundaer_kilde_vurderes_noedvendig\', \'caretaker\', \'tegningsfiler_i_kontainer\', \'bbr_meddelelse\', \'bygningskonsulent_ved_aak\', \'mark_kontrol\') DEFAULT NULL COMMENT \'(DC2Type:ArealKildeSekundaerType)\'');
        $this->addSql('ALTER TABLE fos_user CHANGE username username VARCHAR(180) NOT NULL, CHANGE username_canonical username_canonical VARCHAR(180) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE email_canonical email_canonical VARCHAR(180) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user CHANGE username username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE username_canonical username_canonical VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE email_canonical email_canonical VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
