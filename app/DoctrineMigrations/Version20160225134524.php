<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225134524 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline ADD elForbrugsdataPrimaerKilde ENUM(\'forsyningsselskab\', \'se_elforbrug\', \'keepfocus_fjernaflaesning\', \'keepfocus_manuel_aflaesning\', \'serviceledere_driftspersonale\', \'kmd_opus\', \'mark_kontrol\') DEFAULT NULL COMMENT \'(DC2Type:ElKildePrimaerType)\', ADD elForbrugsdataPrimaer1Aarstal LONGTEXT DEFAULT NULL, ADD elForbrugsdataPrimaer1Forbrug DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataPrimaer2Aarstal LONGTEXT DEFAULT NULL, ADD elForbrugsdataPrimaer2Forbrug DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataPrimaer3Aarstal LONGTEXT DEFAULT NULL, ADD elForbrugsdataPrimaer3Forbrug DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataPrimaerGennemsnit DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataPrimaerNoegetal DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataPrimaerNoter LONGTEXT DEFAULT NULL, ADD elForbrugsdataSekundaerKilde ENUM(\'ingen_sekundaer_kilde_vurderes_noedvendig\', \'forsyningsselskab\', \'keepfocus_fjernaflaesning\', \'keepfocus_manuel_aflaesning\', \'serviceledere_driftspersonale\', \'kmd_opus\', \'mark_kontrol\') DEFAULT NULL COMMENT \'(DC2Type:ElKildeSekundaerType)\', ADD elForbrugsdataSekundaer1Aarstal LONGTEXT DEFAULT NULL, ADD elForbrugsdataSekundaer1Forbrug DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataSekundaer2Aarstal LONGTEXT DEFAULT NULL, ADD elForbrugsdataSekundaer2Forbrug DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataSekundaer3Aarstal LONGTEXT DEFAULT NULL, ADD elForbrugsdataSekundaer3Forbrug DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataSekundaerGennemsnit DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataSekundaerNoegetal DOUBLE PRECISION DEFAULT NULL, ADD elForbrugsdataSekundaerNoter LONGTEXT DEFAULT NULL, ADD elBaselineFastsatForEjendom DOUBLE PRECISION DEFAULT NULL, ADD elBaselineNoegletalForEjendom DOUBLE PRECISION DEFAULT NULL, ADD elBaselineNoter DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP elForbrugsdataPrimaerKilde, DROP elForbrugsdataPrimaer1Aarstal, DROP elForbrugsdataPrimaer1Forbrug, DROP elForbrugsdataPrimaer2Aarstal, DROP elForbrugsdataPrimaer2Forbrug, DROP elForbrugsdataPrimaer3Aarstal, DROP elForbrugsdataPrimaer3Forbrug, DROP elForbrugsdataPrimaerGennemsnit, DROP elForbrugsdataPrimaerNoegetal, DROP elForbrugsdataPrimaerNoter, DROP elForbrugsdataSekundaerKilde, DROP elForbrugsdataSekundaer1Aarstal, DROP elForbrugsdataSekundaer1Forbrug, DROP elForbrugsdataSekundaer2Aarstal, DROP elForbrugsdataSekundaer2Forbrug, DROP elForbrugsdataSekundaer3Aarstal, DROP elForbrugsdataSekundaer3Forbrug, DROP elForbrugsdataSekundaerGennemsnit, DROP elForbrugsdataSekundaerNoegetal, DROP elForbrugsdataSekundaerNoter, DROP elBaselineFastsatForEjendom, DROP elBaselineNoegletalForEjendom, DROP elBaselineNoter');
    }
}
