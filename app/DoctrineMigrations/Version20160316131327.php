<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160316131327 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD anlaegsinvestering_beregnet DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD anlaegsinvestering_beregnet DOUBLE PRECISION DEFAULT NULL');

        $this->addSql('UPDATE Tiltag set anlaegsinvestering_beregnet = anlaegsinvestering;');
        $this->addSql('UPDATE Tiltag_audit set anlaegsinvestering_beregnet = anlaegsinvestering;');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE Tiltag set anlaegsinvestering = anlaegsinvestering_beregnet;');
        $this->addSql('UPDATE Tiltag_audit set anlaegsinvestering = anlaegsinvestering_beregnet;');

        $this->addSql('ALTER TABLE Tiltag DROP anlaegsinvestering_beregnet');
        $this->addSql('ALTER TABLE Tiltag_audit DROP anlaegsinvestering_beregnet');
    }
}
