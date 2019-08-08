<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190808144851 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE VirksomhedRapport (id INT AUTO_INCREMENT NOT NULL, virksomhed_id INT DEFAULT NULL, version VARCHAR(255) NOT NULL, Datering DATE NOT NULL, datoForDrift DATE DEFAULT NULL, besparelseAarEt DOUBLE PRECISION DEFAULT NULL, fravalgtbesparelseAarEt DOUBLE PRECISION DEFAULT NULL, besparelseVarmeGUF DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseVarmeGUF DOUBLE PRECISION DEFAULT NULL, besparelseVarmeGAF DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseVarmeGAF DOUBLE PRECISION DEFAULT NULL, besparelseCO2 DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseCO2 DOUBLE PRECISION DEFAULT NULL, besparelseEl DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseEl DOUBLE PRECISION DEFAULT NULL, co2BesparelseEl DOUBLE PRECISION DEFAULT NULL, co2BesparelseVarme DOUBLE PRECISION DEFAULT NULL, BaselineCO2El DOUBLE PRECISION DEFAULT NULL, BaselineCO2Varme DOUBLE PRECISION DEFAULT NULL, BaselineCO2Samlet DOUBLE PRECISION DEFAULT NULL, fravalgtBaselineCO2Samlet DOUBLE PRECISION DEFAULT NULL, co2BesparelseElFaktor DOUBLE PRECISION DEFAULT NULL, co2BesparelseVarmeFaktor DOUBLE PRECISION DEFAULT NULL, co2BesparelseSamletFaktor DOUBLE PRECISION DEFAULT NULL, fravalgtCo2BesparelseSamletFaktor DOUBLE PRECISION DEFAULT NULL, BaselineEl NUMERIC(16, 4) DEFAULT NULL, BaselineVarmeGUF NUMERIC(16, 4) DEFAULT NULL, BaselineVarmeGAF NUMERIC(16, 4) DEFAULT NULL, BaselineVand NUMERIC(16, 4) DEFAULT NULL, BaselineStrafAfkoeling NUMERIC(16, 4) DEFAULT NULL, faktorPaaVarmebesparelse NUMERIC(10, 4) DEFAULT NULL, energiscreening NUMERIC(16, 4) DEFAULT NULL, anlaegsinvestering DOUBLE PRECISION DEFAULT NULL, fravalgtAnlaegsinvestering DOUBLE PRECISION DEFAULT NULL, nutidsvaerdiSetOver15AarKr DOUBLE PRECISION DEFAULT NULL, fravalgtNutidsvaerdiSetOver15AarKr DOUBLE PRECISION DEFAULT NULL, mtmFaellesomkostninger DOUBLE PRECISION DEFAULT NULL, implementering DOUBLE PRECISION DEFAULT NULL, fravalgtimplementering DOUBLE PRECISION DEFAULT NULL, faellesomkostninger DOUBLE PRECISION DEFAULT NULL, internRenteInklFaellesomkostninger DOUBLE PRECISION DEFAULT NULL, laanLoebetid INT DEFAULT NULL, elena TINYINT(1) DEFAULT NULL, ava TINYINT(1) DEFAULT NULL, cashFlow15 LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', cashFlow30 LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', energibudgetVarme DOUBLE PRECISION DEFAULT NULL, energibudgetEl DOUBLE PRECISION DEFAULT NULL, fravalgtBesparelseDriftOgVedligeholdelse DOUBLE PRECISION DEFAULT NULL, cashFlow LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', Genopretning NUMERIC(10, 0) DEFAULT NULL, genopretningForImplementeringsomkostninger NUMERIC(10, 0) DEFAULT NULL, Modernisering NUMERIC(10, 0) DEFAULT NULL, FravalgtGenopretning NUMERIC(10, 0) DEFAULT NULL, FravalgtModernisering NUMERIC(10, 0) DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_7F1B6C09D62CEA9 (virksomhed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE VirksomhedRapport ADD CONSTRAINT FK_7F1B6C09D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE VirksomhedRapport');
    }
}
