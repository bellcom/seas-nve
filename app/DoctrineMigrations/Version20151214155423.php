<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151214155423 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration ADD solcelletiltagdetail_salgsprisFoerste10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, ADD solcelletiltagdetail_salgsprisEfter10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE solcelle_forringetydeevnepraar solcelletiltagdetail_energiprisstigningPctPrAar NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Configuration_audit ADD solcelletiltagdetail_salgsprisFoerste10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, ADD solcelletiltagdetail_salgsprisEfter10AarKrKWh NUMERIC(10, 4) DEFAULT NULL, CHANGE solcelle_forringetydeevnepraar solcelletiltagdetail_energiprisstigningPctPrAar NUMERIC(10, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration ADD solcelle_forringetYdeevnePrAar NUMERIC(10, 4) DEFAULT NULL, DROP solcelletiltagdetail_energiprisstigningPctPrAar, DROP solcelletiltagdetail_salgsprisFoerste10AarKrKWh, DROP solcelletiltagdetail_salgsprisEfter10AarKrKWh');
        $this->addSql('ALTER TABLE Configuration_audit ADD solcelle_forringetYdeevnePrAar NUMERIC(10, 4) DEFAULT NULL, DROP solcelletiltagdetail_energiprisstigningPctPrAar, DROP solcelletiltagdetail_salgsprisFoerste10AarKrKWh, DROP solcelletiltagdetail_salgsprisEfter10AarKrKWh');
    }
}
