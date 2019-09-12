<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190911055318 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag CHANGE prioriteringsfaktor prioriteringsfaktor DOUBLE PRECISION NOT NULL, CHANGE konverteringsfaktor konverteringsfaktor DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit CHANGE prioriteringsfaktor prioriteringsfaktor DOUBLE PRECISION DEFAULT NULL, CHANGE konverteringsfaktor konverteringsfaktor DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag CHANGE prioriteringsfaktor prioriteringsfaktor INT NOT NULL, CHANGE konverteringsfaktor konverteringsfaktor INT NOT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit CHANGE prioriteringsfaktor prioriteringsfaktor INT DEFAULT NULL, CHANGE konverteringsfaktor konverteringsfaktor INT DEFAULT NULL');
    }
}
