<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160405162034 extends AbstractMigration {
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD cashFlow LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Rapport_audit ADD cashFlow LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');

        // Set an empty cash flow.
        $cashFlow = array();
        $this->addSql('UPDATE Rapport SET cashFlow = \'' . serialize($cashFlow) .'\'');

        $this->write('

<comment>Please run

app/console aaplus:post-migrate

to update cash flows in database after migrations have run.</comment>

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

        $this->addSql('ALTER TABLE Rapport DROP cashFlow');
        $this->addSql('ALTER TABLE Rapport_audit DROP cashFlow');
    }
}
