<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190815083120 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ContactPerson CHANGE phone_number phone_number VARCHAR(255) DEFAULT NULL, CHANGE mail mail VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD region VARCHAR(255) DEFAULT NULL, ADD `by_nanv` VARCHAR(255) DEFAULT NULL, ADD postnummer VARCHAR(255) DEFAULT NULL, ADD erhvervs_areal VARCHAR(255) DEFAULT NULL, ADD opvarmet_areal VARCHAR(255) DEFAULT NULL, ADD aars_vaerk VARCHAR(255) DEFAULT NULL, ADD forbrug VARCHAR(255) DEFAULT NULL, ADD er VARCHAR(255) DEFAULT NULL, ADD kam VARCHAR(255) DEFAULT NULL, CHANGE env_p_number kommune VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ContactPerson CHANGE phone_number phone_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE mail mail VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Virksomhed ADD env_p_number VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP kommune, DROP region, DROP `by_nanv`, DROP postnummer, DROP erhvervs_areal, DROP opvarmet_areal, DROP aars_vaerk, DROP forbrug, DROP er, DROP kam');
    }
}
