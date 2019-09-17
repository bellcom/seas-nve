<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190917070217 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD konverteringsfaktorEfter DOUBLE PRECISION NOT NULL, ADD forbrugFoer INT NOT NULL, ADD forbrugEfter INT NOT NULL, CHANGE konverteringsfaktor konverteringsfaktorFoer DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD konverteringsfaktorEfter DOUBLE PRECISION DEFAULT NULL, ADD forbrugFoer INT DEFAULT NULL, ADD forbrugEfter INT DEFAULT NULL, CHANGE konverteringsfaktor konverteringsfaktorFoer DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD konverteringsfaktor DOUBLE PRECISION NOT NULL, DROP konverteringsfaktorFoer, DROP konverteringsfaktorEfter, DROP forbrugFoer, DROP forbrugEfter');
        $this->addSql('ALTER TABLE Tiltag_audit ADD konverteringsfaktor DOUBLE PRECISION DEFAULT NULL, DROP konverteringsfaktorFoer, DROP konverteringsfaktorEfter, DROP forbrugFoer, DROP forbrugEfter');
    }
}
