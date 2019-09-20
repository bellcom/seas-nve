<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190923083224 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE VirksomhedRapport_audit (id INT NOT NULL, rev INT NOT NULL, virksomhed_id INT DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, Datering DATE DEFAULT NULL, datoForDrift DATE DEFAULT NULL, besparelseAarEt DOUBLE PRECISION DEFAULT NULL, fravalgtbesparelseAarEt DOUBLE PRECISION DEFAULT NULL, besparelseVarmeGUF DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseVarmeGUF DOUBLE PRECISION DEFAULT NULL, besparelseVarmeGAF DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseVarmeGAF DOUBLE PRECISION DEFAULT NULL, besparelseCO2 DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseCO2 DOUBLE PRECISION DEFAULT NULL, besparelseEl DOUBLE PRECISION DEFAULT NULL, besparelseBraendstof DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseEl DOUBLE PRECISION DEFAULT NULL, co2BesparelseEl DOUBLE PRECISION DEFAULT NULL, co2BesparelseVarme DOUBLE PRECISION DEFAULT NULL, co2BesparelseBraendstofITon DOUBLE PRECISION DEFAULT NULL, BaselineCO2El DOUBLE PRECISION DEFAULT NULL, BaselineCO2Varme DOUBLE PRECISION DEFAULT NULL, BaselineCO2Braendstof DOUBLE PRECISION DEFAULT NULL, BaselineCO2Samlet DOUBLE PRECISION DEFAULT NULL, fravalgtBaselineCO2Samlet DOUBLE PRECISION DEFAULT NULL, co2BesparelseElFaktor DOUBLE PRECISION DEFAULT NULL, co2BesparelseVarmeFaktor DOUBLE PRECISION DEFAULT NULL, co2BesparelseBraendstofFaktor DOUBLE PRECISION DEFAULT NULL, co2BesparelseSamletFaktor DOUBLE PRECISION DEFAULT NULL, fravalgtCo2BesparelseSamletFaktor DOUBLE PRECISION DEFAULT NULL, BaselineEl NUMERIC(16, 4) DEFAULT NULL, BaselineVarmeGUF NUMERIC(16, 4) DEFAULT NULL, BaselineVarmeGAF NUMERIC(16, 4) DEFAULT NULL, BaselineBraendstof NUMERIC(16, 4) DEFAULT NULL, BaselineVand NUMERIC(16, 4) DEFAULT NULL, BaselineStrafAfkoeling NUMERIC(16, 4) DEFAULT NULL, faktorPaaVarmebesparelse NUMERIC(10, 4) DEFAULT NULL, energiscreening NUMERIC(16, 4) DEFAULT NULL, anlaegsinvestering DOUBLE PRECISION DEFAULT NULL, fravalgtAnlaegsinvestering DOUBLE PRECISION DEFAULT NULL, nutidsvaerdiSetOver15AarKr DOUBLE PRECISION DEFAULT NULL, fravalgtNutidsvaerdiSetOver15AarKr DOUBLE PRECISION DEFAULT NULL, mtmFaellesomkostninger DOUBLE PRECISION DEFAULT NULL, implementering DOUBLE PRECISION DEFAULT NULL, fravalgtimplementering DOUBLE PRECISION DEFAULT NULL, faellesomkostninger DOUBLE PRECISION DEFAULT NULL, internRenteInklFaellesomkostninger DOUBLE PRECISION DEFAULT NULL, laanLoebetid INT DEFAULT NULL, elena TINYINT(1) DEFAULT NULL, ava TINYINT(1) DEFAULT NULL, cashFlow15 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', cashFlow30 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', energibudgetVarme DOUBLE PRECISION DEFAULT NULL, energibudgetEl DOUBLE PRECISION DEFAULT NULL, energibudgetBraendstof DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseDriftOgVedligeholdelse DOUBLE PRECISION DEFAULT NULL, Genopretning NUMERIC(10, 0) DEFAULT NULL, genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL, Modernisering NUMERIC(10, 0) DEFAULT NULL, FravalgtGenopretning NUMERIC(10, 0) DEFAULT NULL, FravalgtModernisering NUMERIC(10, 0) DEFAULT NULL, cashFlow LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', erhvervsareal INT DEFAULT NULL, opvarmetareal INT DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, revtype VARCHAR(4) NOT NULL, INDEX rev_35b2037c092d2a26073bb2542811339c_idx (rev), PRIMARY KEY(id, rev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Baseline DROP FOREIGN KEY FK_F6FB110206C32AA');
        $this->addSql('DROP INDEX uniq_f6fb110206c32aa ON Baseline');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6FB1109D62CEA9 ON Baseline (virksomhed_id)');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB110206C32AA FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('ALTER TABLE VirksomhedRapport ADD BaselineCO2Braendstof DOUBLE PRECISION DEFAULT NULL, ADD BaselineBraendstof NUMERIC(16, 4) DEFAULT NULL, ADD energibudgetBraendstof DOUBLE PRECISION DEFAULT NULL, CHANGE co2besparelsebraendstof co2BesparelseBraendstofFaktor DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport ADD BaselineCO2Braendstof DOUBLE PRECISION DEFAULT NULL, ADD fravalgtBesparelseBraendstof DOUBLE PRECISION DEFAULT NULL, ADD BaselineBraendstof NUMERIC(16, 4) DEFAULT NULL, ADD energibudgetBraendstof DOUBLE PRECISION DEFAULT NULL, CHANGE co2besparelsebraendstof co2BesparelseBraendstofFaktor DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD BaselineCO2Braendstof DOUBLE PRECISION DEFAULT NULL, ADD fravalgtBesparelseBraendstof DOUBLE PRECISION DEFAULT NULL, ADD BaselineBraendstof NUMERIC(16, 4) DEFAULT NULL, ADD energibudgetBraendstof DOUBLE PRECISION DEFAULT NULL, CHANGE co2besparelsebraendstof co2BesparelseBraendstofFaktor DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE VirksomhedRapport_audit');
        $this->addSql('ALTER TABLE Baseline DROP FOREIGN KEY FK_F6FB1109D62CEA9');
        $this->addSql('DROP INDEX uniq_f6fb1109d62cea9 ON Baseline');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6FB110206C32AA ON Baseline (virksomhed_id)');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB1109D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('ALTER TABLE Rapport CHANGE co2BesparelseBraendstofFaktor co2BesparelseBraendstof DOUBLE PRECISION DEFAULT NULL, DROP fravalgtBesparelseBraendstof, DROP BaselineCO2Braendstof, DROP BaselineBraendstof, DROP energibudgetBraendstof');
        $this->addSql('ALTER TABLE Rapport_audit CHANGE co2BesparelseBraendstofFaktor co2BesparelseBraendstof DOUBLE PRECISION DEFAULT NULL, DROP fravalgtBesparelseBraendstof, DROP BaselineCO2Braendstof, DROP BaselineBraendstof, DROP energibudgetBraendstof');
        $this->addSql('ALTER TABLE VirksomhedRapport CHANGE co2BesparelseBraendstofFaktor co2BesparelseBraendstof DOUBLE PRECISION DEFAULT NULL, DROP BaselineCO2Braendstof, DROP BaselineBraendstof, DROP energibudgetBraendstof');
    }
}
