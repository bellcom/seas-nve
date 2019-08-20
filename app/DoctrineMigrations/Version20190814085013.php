<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190814085013 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ContactPerson (id INT AUTO_INCREMENT NOT NULL, virksomhed_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, INDEX IDX_271C63269D62CEA9 (virksomhed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ContactPerson ADD CONSTRAINT FK_271C63269D62CEA9 FOREIGN KEY (virksomhed_id) REFERENCES Virksomhed (id)');
        $this->addSql('ALTER TABLE Virksomhed ADD project_number VARCHAR(255) DEFAULT NULL, ADD aftager_number VARCHAR(255) DEFAULT NULL, ADD type_name ENUM(\'screening\', \'undeseogelse\', \'emo\', \'energiledelse\', \'energisyn\') DEFAULT NULL COMMENT \'(DC2Type:VirksomhedTypeType)\', ADD nace_code VARCHAR(255) DEFAULT NULL, ADD dsm_code VARCHAR(255) DEFAULT NULL, ADD energy_price VARCHAR(255) DEFAULT NULL, DROP branch_code, DROP contact_person, DROP phone_number, CHANGE crm_number crm_number VARCHAR(255) DEFAULT NULL, CHANGE customer_number customer_number VARCHAR(255) DEFAULT NULL, CHANGE subsidy_level subsidy_size NUMERIC(10, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ContactPerson');
        $this->addSql('ALTER TABLE Virksomhed ADD branch_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD contact_person VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD phone_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP project_number, DROP aftager_number, DROP type_name, DROP nace_code, DROP dsm_code, DROP energy_price, CHANGE crm_number crm_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE customer_number customer_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE subsidy_size subsidy_level NUMERIC(10, 4) DEFAULT NULL');
    }
}
