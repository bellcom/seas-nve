<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160222132127 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD co2BesparelseElProcent DOUBLE PRECISION DEFAULT NULL, ADD co2BesparelseVarmeProcent DOUBLE PRECISION DEFAULT NULL, ADD besparelseCO2Procent DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD co2BesparelseElProcent DOUBLE PRECISION DEFAULT NULL, ADD co2BesparelseVarmeProcent DOUBLE PRECISION DEFAULT NULL, ADD besparelseCO2Procent DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP co2BesparelseElProcent, DROP co2BesparelseVarmeProcent, DROP besparelseCO2Procent');
        $this->addSql('ALTER TABLE Rapport_audit DROP co2BesparelseElProcent, DROP co2BesparelseVarmeProcent, DROP besparelseCO2Procent');
    }
}
