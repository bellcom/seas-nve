<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171103140734 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration ADD mtmFaellesomkostningerGrundpris NUMERIC(10, 4) DEFAULT NULL, ADD mtmFaellesomkostningerPrisPrM2 NUMERIC(10, 4) DEFAULT NULL, ADD mtmFaellesomkostningerNulHvisArealMindreEnd DOUBLE PRECISION NOT NULL, ADD mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE Configuration_audit ADD mtmFaellesomkostningerGrundpris NUMERIC(10, 4) DEFAULT NULL, ADD mtmFaellesomkostningerPrisPrM2 NUMERIC(10, 4) DEFAULT NULL, ADD mtmFaellesomkostningerNulHvisArealMindreEnd DOUBLE PRECISION DEFAULT NULL, ADD mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd DOUBLE PRECISION DEFAULT NULL');

        $this->addSql('UPDATE Configuration SET mtmFaellesomkostningerGrundpris = 5000, mtmFaellesomkostningerPrisPrM2 = 5, mtmFaellesomkostningerNulHvisArealMindreEnd = 400, mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd = 70000');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Configuration DROP mtmFaellesomkostningerGrundpris, DROP mtmFaellesomkostningerPrisPrM2, DROP mtmFaellesomkostningerNulHvisArealMindreEnd, DROP mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd');
        $this->addSql('ALTER TABLE Configuration_audit DROP mtmFaellesomkostningerGrundpris, DROP mtmFaellesomkostningerPrisPrM2, DROP mtmFaellesomkostningerNulHvisArealMindreEnd, DROP mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd');
    }
}
