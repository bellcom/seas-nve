<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190923092053 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline ADD braendstofForbrug NUMERIC(16, 4) DEFAULT NULL, ADD braendstofForbrugKorrektion DOUBLE PRECISION DEFAULT NULL, ADD braendstofForbrugKorrigeret DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Baseline_audit ADD braendstofForbrug NUMERIC(16, 4) DEFAULT NULL, ADD braendstofForbrugKorrektion DOUBLE PRECISION DEFAULT NULL, ADD braendstofForbrugKorrigeret DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE BaselineKorrektion ADD korrektionBraendstof NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE BaselineKorrektion_audit ADD korrektionBraendstof NUMERIC(10, 0) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP braendstofForbrug, DROP braendstofForbrugKorrektion, DROP braendstofForbrugKorrigeret');
        $this->addSql('ALTER TABLE BaselineKorrektion DROP korrektionBraendstof');
        $this->addSql('ALTER TABLE BaselineKorrektion_audit DROP korrektionBraendstof');
        $this->addSql('ALTER TABLE Baseline_audit DROP braendstofForbrug, DROP braendstofForbrugKorrektion, DROP braendstofForbrugKorrigeret');
    }
}
