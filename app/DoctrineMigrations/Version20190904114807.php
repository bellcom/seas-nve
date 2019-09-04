<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190904114807 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Virksomhed ADD vand_forsyningsvaerk_id INT DEFAULT NULL, ADD varme_forsyningsvaerk_id INT DEFAULT NULL, ADD el_forsyningsvaerk_id INT DEFAULT NULL, DROP energy_price, DROP er, DROP erhvervs_areal, DROP opvarmet_areal');
        $this->addSql('ALTER TABLE Virksomhed ADD CONSTRAINT FK_8B8D37627B117FB FOREIGN KEY (vand_forsyningsvaerk_id) REFERENCES Forsyningsvaerk (id)');
        $this->addSql('ALTER TABLE Virksomhed ADD CONSTRAINT FK_8B8D376238B1907B FOREIGN KEY (varme_forsyningsvaerk_id) REFERENCES Forsyningsvaerk (id)');
        $this->addSql('ALTER TABLE Virksomhed ADD CONSTRAINT FK_8B8D3762494C9F49 FOREIGN KEY (el_forsyningsvaerk_id) REFERENCES Forsyningsvaerk (id)');
        $this->addSql('CREATE INDEX IDX_8B8D37627B117FB ON Virksomhed (vand_forsyningsvaerk_id)');
        $this->addSql('CREATE INDEX IDX_8B8D376238B1907B ON Virksomhed (varme_forsyningsvaerk_id)');
        $this->addSql('CREATE INDEX IDX_8B8D3762494C9F49 ON Virksomhed (el_forsyningsvaerk_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Virksomhed DROP FOREIGN KEY FK_8B8D37627B117FB');
        $this->addSql('ALTER TABLE Virksomhed DROP FOREIGN KEY FK_8B8D376238B1907B');
        $this->addSql('ALTER TABLE Virksomhed DROP FOREIGN KEY FK_8B8D3762494C9F49');
        $this->addSql('DROP INDEX IDX_8B8D37627B117FB ON Virksomhed');
        $this->addSql('DROP INDEX IDX_8B8D376238B1907B ON Virksomhed');
        $this->addSql('DROP INDEX IDX_8B8D3762494C9F49 ON Virksomhed');
        $this->addSql('ALTER TABLE Virksomhed ADD energy_price VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD er VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD erhvervs_areal VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD opvarmet_areal VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP vand_forsyningsvaerk_id, DROP varme_forsyningsvaerk_id, DROP el_forsyningsvaerk_id');
    }
}
