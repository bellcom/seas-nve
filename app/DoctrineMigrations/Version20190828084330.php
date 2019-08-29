<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190828084330 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP dieselPris, DROP benzinPris, DROP antalGulpladeBiler, DROP antalHvidpladeBiler, DROP forbrugForGulpladeBiler, DROP forbrugForHvidpladeBiler');
        $this->addSql('ALTER TABLE Tiltag_audit DROP dieselPris, DROP benzinPris, DROP antalGulpladeBiler, DROP antalHvidpladeBiler, DROP forbrugForGulpladeBiler, DROP forbrugForHvidpladeBiler');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD dieselPris NUMERIC(14, 4) DEFAULT NULL, ADD benzinPris NUMERIC(14, 4) DEFAULT NULL, ADD antalGulpladeBiler NUMERIC(14, 4) DEFAULT NULL, ADD antalHvidpladeBiler NUMERIC(14, 4) DEFAULT NULL, ADD forbrugForGulpladeBiler NUMERIC(14, 4) DEFAULT NULL, ADD forbrugForHvidpladeBiler NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD dieselPris NUMERIC(14, 4) DEFAULT NULL, ADD benzinPris NUMERIC(14, 4) DEFAULT NULL, ADD antalGulpladeBiler NUMERIC(14, 4) DEFAULT NULL, ADD antalHvidpladeBiler NUMERIC(14, 4) DEFAULT NULL, ADD forbrugForGulpladeBiler NUMERIC(14, 4) DEFAULT NULL, ADD forbrugForHvidpladeBiler NUMERIC(14, 4) DEFAULT NULL');
    }
}
