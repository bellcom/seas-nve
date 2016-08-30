<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160413123036 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD maengde DOUBLE PRECISION DEFAULT NULL, ADD enhed VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD maengde DOUBLE PRECISION DEFAULT NULL, ADD enhed VARCHAR(255) DEFAULT NULL');

        $this->write('

<comment>Please run

app/console aaplus:post-migrate

to update "maengde" and "enhed" in database after migrations have run.</comment>

');
        readline('Capisce? ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP maengde, DROP enhed');
        $this->addSql('ALTER TABLE Tiltag_audit DROP maengde, DROP enhed');
    }
}
