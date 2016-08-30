<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160531131203 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport ADD energibudgetVarme DOUBLE PRECISION DEFAULT NULL, ADD energibudgetEl DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Rapport_audit ADD energibudgetVarme DOUBLE PRECISION DEFAULT NULL, ADD energibudgetEl DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Rapport DROP energibudgetVarme, DROP energibudgetEl');
        $this->addSql('ALTER TABLE Rapport_audit DROP energibudgetVarme, DROP energibudgetEl');
    }
}
