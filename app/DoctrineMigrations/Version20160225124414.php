<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225124414 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline ADD arealdataPrimaerKilde ENUM(\'caretaker\', \'tegningsfiler_i_kontainer\', \'bbr_meddelelse\', \'bygningskonsulent_ved_aak\', \'mark_kontrol\') DEFAULT NULL COMMENT \'(DC2Type:ArealKildePrimaerType)\', ADD arealdataPrimaerAreal DOUBLE PRECISION DEFAULT NULL, ADD arealdataPrimaerNoter LONGTEXT DEFAULT NULL, ADD arealdataSekundaerKilde ENUM(\'Ingen sekundær kilde vurderes nødvendig\', \'caretaker\', \'tegningsfiler_i_kontainer\', \'bbr_meddelelse\', \'bygningskonsulent_ved_aak\', \'mark_kontrol\') DEFAULT NULL COMMENT \'(DC2Type:ArealKildeSekundaerType)\', ADD arealdataSekundaerAreal DOUBLE PRECISION DEFAULT NULL, ADD arealdataSekundaerNoter LONGTEXT DEFAULT NULL, ADD arealTilNoegletalsanalyse DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP arealdataPrimaerKilde, DROP arealdataPrimaerAreal, DROP arealdataPrimaerNoter, DROP arealdataSekundaerKilde, DROP arealdataSekundaerAreal, DROP arealdataSekundaerNoter, DROP arealTilNoegletalsanalyse');
    }
}
