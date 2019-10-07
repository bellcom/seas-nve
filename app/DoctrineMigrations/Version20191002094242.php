<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191002094242 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport ADD kortlaegningKonklusionTekst LONGTEXT DEFAULT NULL, ADD kortlaegningVirksomhedBeskrivelse LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit ADD kortlaegningKonklusionTekst LONGTEXT DEFAULT NULL, ADD kortlaegningVirksomhedBeskrivelse LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE VirksomhedRapport DROP kortlaegningKonklusionTekst, DROP kortlaegningVirksomhedBeskrivelse');
        $this->addSql('ALTER TABLE VirksomhedRapport_audit DROP kortlaegningKonklusionTekst, DROP kortlaegningVirksomhedBeskrivelse');
    }
}
