<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200518141414 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP prioriteringsfaktor, DROP konverteringsfaktorFoer, DROP konverteringsfaktorEfter');
        $this->addSql('ALTER TABLE Tiltag_audit DROP prioriteringsfaktor, DROP konverteringsfaktorFoer, DROP konverteringsfaktorEfter');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD prioriteringsfaktor DOUBLE PRECISION NOT NULL, ADD konverteringsfaktorFoer DOUBLE PRECISION NOT NULL, ADD konverteringsfaktorEfter DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD prioriteringsfaktor DOUBLE PRECISION DEFAULT NULL, ADD konverteringsfaktorFoer DOUBLE PRECISION DEFAULT NULL, ADD konverteringsfaktorEfter DOUBLE PRECISION DEFAULT NULL');
    }
}
