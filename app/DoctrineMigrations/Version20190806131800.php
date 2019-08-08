<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190806131800 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Virksomhed (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, cvr_number VARCHAR(255) NOT NULL, branch_code VARCHAR(255) NOT NULL, contact_person VARCHAR(255) NOT NULL, customer_number VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, subsidy_level NUMERIC(10, 4) DEFAULT NULL, kalkulationsrente NUMERIC(10, 4) DEFAULT NULL, inflation NUMERIC(10, 4) DEFAULT NULL, lobetid NUMERIC(10, 4) DEFAULT NULL, env_p_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Bygning ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning ADD CONSTRAINT FK_FD908E379D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('CREATE INDEX IDX_FD908E379D62CEA9 ON Bygning (virksomhed_id)');
        $this->addSql('ALTER TABLE Bygning_audit ADD virksomhed_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Configuration CHANGE mtmFaellesomkostningerNulHvisArealMindreEnd mtmFaellesomkostningerNulHvisArealMindreEnd DOUBLE PRECISION NOT NULL, CHANGE mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd DOUBLE PRECISION NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bygning DROP FOREIGN KEY FK_FD908E379D62CEA9');
        $this->addSql('DROP TABLE Virksomhed');
        $this->addSql('DROP INDEX IDX_FD908E379D62CEA9 ON Bygning');
        $this->addSql('ALTER TABLE Bygning DROP virksomhed_id');
        $this->addSql('ALTER TABLE Bygning_audit DROP virksomhed_id');
        $this->addSql('ALTER TABLE Configuration CHANGE mtmFaellesomkostningerNulHvisArealMindreEnd mtmFaellesomkostningerNulHvisArealMindreEnd DOUBLE PRECISION DEFAULT NULL, CHANGE mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd DOUBLE PRECISION DEFAULT NULL');
    }
}
