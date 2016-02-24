<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160224103439 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bygning DROP Ident, DROP Enhedskode, DROP Ejer, DROP Maalertype, DROP Kundenummer, DROP Kode, DROP Kundenr_1, DROP Kode_1, DROP MaalerskifteAFV, DROP AFVInstnr_1, DROP Instnr, DROP Kundenr_NRGI, DROP internetkode, DROP Aftagenr, DROP Telefon, DROP Kommune, DROP Magistrat, DROP Lokation, DROP Lokationsnavn, DROP Lederbetegnelse, DROP Ledersnavn, DROP Ledersmail, DROP Kontakt_Notat, DROP Stamdata_Notat, DROP Vand_Notat, DROP El_Notat, DROP Varme_Notat');
        $this->addSql('ALTER TABLE Bygning_audit DROP Ident, DROP Enhedskode, DROP Ejer, DROP Maalertype, DROP Kundenummer, DROP Kode, DROP Kundenr_1, DROP Kode_1, DROP MaalerskifteAFV, DROP AFVInstnr_1, DROP Instnr, DROP Kundenr_NRGI, DROP internetkode, DROP Aftagenr, DROP Telefon, DROP Kommune, DROP Magistrat, DROP Lokation, DROP Lokationsnavn, DROP Lederbetegnelse, DROP Ledersnavn, DROP Ledersmail, DROP Kontakt_Notat, DROP Stamdata_Notat, DROP Vand_Notat, DROP El_Notat, DROP Varme_Notat');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Bygning ADD Ident INT DEFAULT NULL, ADD Enhedskode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Ejer VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Maalertype VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kundenummer VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kundenr_1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kode_1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD MaalerskifteAFV VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD AFVInstnr_1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Instnr VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kundenr_NRGI VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD internetkode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Aftagenr VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Telefon INT DEFAULT NULL, ADD Kommune INT DEFAULT NULL, ADD Magistrat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Lokation VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Lokationsnavn VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Lederbetegnelse VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Ledersnavn VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Ledersmail VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kontakt_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Stamdata_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Vand_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD El_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Varme_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Bygning_audit ADD Ident INT DEFAULT NULL, ADD Enhedskode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Ejer VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Maalertype VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kundenummer VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kundenr_1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kode_1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD MaalerskifteAFV VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD AFVInstnr_1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Instnr VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kundenr_NRGI VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD internetkode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Aftagenr VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Telefon INT DEFAULT NULL, ADD Kommune INT DEFAULT NULL, ADD Magistrat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Lokation VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Lokationsnavn VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Lederbetegnelse VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Ledersnavn VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Ledersmail VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Kontakt_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Stamdata_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Vand_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD El_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD Varme_Notat VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
