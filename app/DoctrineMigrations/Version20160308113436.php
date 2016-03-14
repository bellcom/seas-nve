<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160308113436 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag CHANGE besparelseGUF besparelseGUF NUMERIC(14, 4) DEFAULT NULL, CHANGE besparelseGAF besparelseGAF NUMERIC(14, 4) DEFAULT NULL, CHANGE besparelseEl besparelseEl NUMERIC(14, 4) DEFAULT NULL, CHANGE yderligereBesparelse yderligereBesparelse NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit CHANGE besparelseGUF besparelseGUF NUMERIC(14, 4) DEFAULT NULL, CHANGE besparelseGAF besparelseGAF NUMERIC(14, 4) DEFAULT NULL, CHANGE besparelseEl besparelseEl NUMERIC(14, 4) DEFAULT NULL, CHANGE yderligereBesparelse yderligereBesparelse NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail CHANGE uEksWM2K uEksWM2K NUMERIC(14, 4) DEFAULT NULL, CHANGE anlaegsstoerrelseKWp anlaegsstoerrelseKWp NUMERIC(14, 4) DEFAULT NULL, CHANGE produktionKWh produktionKWh NUMERIC(14, 4) DEFAULT NULL, CHANGE forringetYdeevnePrAar forringetYdeevnePrAar NUMERIC(14, 4) DEFAULT NULL, CHANGE salgsprisFoerste10AarKrKWh salgsprisFoerste10AarKrKWh NUMERIC(14, 4) DEFAULT NULL, CHANGE salgsprisEfter10AarKrKWh salgsprisEfter10AarKrKWh NUMERIC(14, 4) DEFAULT NULL, CHANGE screeningOgProjekteringKr screeningOgProjekteringKr NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit CHANGE uEksWM2K uEksWM2K NUMERIC(14, 4) DEFAULT NULL, CHANGE anlaegsstoerrelseKWp anlaegsstoerrelseKWp NUMERIC(14, 4) DEFAULT NULL, CHANGE produktionKWh produktionKWh NUMERIC(14, 4) DEFAULT NULL, CHANGE forringetYdeevnePrAar forringetYdeevnePrAar NUMERIC(14, 4) DEFAULT NULL, CHANGE salgsprisFoerste10AarKrKWh salgsprisFoerste10AarKrKWh NUMERIC(14, 4) DEFAULT NULL, CHANGE salgsprisEfter10AarKrKWh salgsprisEfter10AarKrKWh NUMERIC(14, 4) DEFAULT NULL, CHANGE screeningOgProjekteringKr screeningOgProjekteringKr NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Klimaskaerm CHANGE enhedsprisEksklMoms enhedsprisEksklMoms NUMERIC(14, 4) NOT NULL');
        $this->addSql('ALTER TABLE Solcelle CHANGE KWp KWp NUMERIC(14, 4) NOT NULL, CHANGE inverterpris inverterpris NUMERIC(14, 4) NOT NULL, CHANGE drift drift NUMERIC(14, 4) NOT NULL');
        $this->addSql('ALTER TABLE Solcelle_audit CHANGE KWp KWp NUMERIC(14, 4) DEFAULT NULL, CHANGE inverterpris inverterpris NUMERIC(14, 4) DEFAULT NULL, CHANGE drift drift NUMERIC(14, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Klimaskaerm CHANGE enhedsprisEksklMoms enhedsprisEksklMoms NUMERIC(10, 4) NOT NULL');
        $this->addSql('ALTER TABLE Solcelle CHANGE KWp KWp NUMERIC(10, 4) NOT NULL, CHANGE inverterpris inverterpris NUMERIC(10, 4) NOT NULL, CHANGE drift drift NUMERIC(10, 4) NOT NULL');
        $this->addSql('ALTER TABLE Solcelle_audit CHANGE KWp KWp NUMERIC(10, 4) DEFAULT NULL, CHANGE inverterpris inverterpris NUMERIC(10, 4) DEFAULT NULL, CHANGE drift drift NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag CHANGE besparelseGUF besparelseGUF NUMERIC(10, 4) DEFAULT NULL, CHANGE besparelseGAF besparelseGAF NUMERIC(10, 4) DEFAULT NULL, CHANGE besparelseEl besparelseEl NUMERIC(10, 4) DEFAULT NULL, CHANGE yderligereBesparelse yderligereBesparelse NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail CHANGE uEksWM2K uEksWM2K NUMERIC(10, 4) DEFAULT NULL, CHANGE anlaegsstoerrelseKWp anlaegsstoerrelseKWp NUMERIC(10, 4) DEFAULT NULL, CHANGE produktionKWh produktionKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE forringetYdeevnePrAar forringetYdeevnePrAar NUMERIC(10, 4) DEFAULT NULL, CHANGE salgsprisFoerste10AarKrKWh salgsprisFoerste10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE salgsprisEfter10AarKrKWh salgsprisEfter10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE screeningOgProjekteringKr screeningOgProjekteringKr NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit CHANGE uEksWM2K uEksWM2K NUMERIC(10, 4) DEFAULT NULL, CHANGE anlaegsstoerrelseKWp anlaegsstoerrelseKWp NUMERIC(10, 4) DEFAULT NULL, CHANGE produktionKWh produktionKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE forringetYdeevnePrAar forringetYdeevnePrAar NUMERIC(10, 4) DEFAULT NULL, CHANGE salgsprisFoerste10AarKrKWh salgsprisFoerste10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE salgsprisEfter10AarKrKWh salgsprisEfter10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE screeningOgProjekteringKr screeningOgProjekteringKr NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit CHANGE besparelseGUF besparelseGUF NUMERIC(10, 4) DEFAULT NULL, CHANGE besparelseGAF besparelseGAF NUMERIC(10, 4) DEFAULT NULL, CHANGE besparelseEl besparelseEl NUMERIC(10, 4) DEFAULT NULL, CHANGE yderligereBesparelse yderligereBesparelse NUMERIC(10, 4) DEFAULT NULL');
    }
}
