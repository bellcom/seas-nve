<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200514123506 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD lyskildeStk INT DEFAULT NULL, ADD benyttelsesFaktor DOUBLE PRECISION DEFAULT NULL, ADD installeretEffektW DOUBLE PRECISION DEFAULT NULL, ADD nyLyskildeStk INT DEFAULT NULL, ADD nyBenyttelsesFaktor DOUBLE PRECISION DEFAULT NULL, ADD nyInstalleretEffektW DOUBLE PRECISION DEFAULT NULL, DROP reduktionAfDrifttid');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD lyskildeStk INT DEFAULT NULL, ADD benyttelsesFaktor DOUBLE PRECISION DEFAULT NULL, ADD installeretEffektW DOUBLE PRECISION DEFAULT NULL, ADD nyLyskildeStk INT DEFAULT NULL, ADD nyBenyttelsesFaktor DOUBLE PRECISION DEFAULT NULL, ADD nyInstalleretEffektW DOUBLE PRECISION DEFAULT NULL, DROP reduktionAfDrifttid');
        $this->addSql('ALTER TABLE TiltagDetail ADD elforbrugkWtAar DOUBLE PRECISION DEFAULT NULL, ADD nytElforbrugkWtAar DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD elforbrugkWtAar DOUBLE PRECISION DEFAULT NULL, ADD nytElforbrugkWtAar DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD reduktionAfDrifttid NUMERIC(10, 4) DEFAULT NULL, DROP lyskildeStk, DROP benyttelsesFaktor, DROP installeretEffektW, DROP nyLyskildeStk, DROP nyBenyttelsesFaktor, DROP nyInstalleretEffektW');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD reduktionAfDrifttid NUMERIC(10, 4) DEFAULT NULL, DROP lyskildeStk, DROP benyttelsesFaktor, DROP installeretEffektW, DROP nyLyskildeStk, DROP nyBenyttelsesFaktor, DROP nyInstalleretEffektW');
        $this->addSql('ALTER TABLE TiltagDetail DROP elforbrugkWtAar, DROP nytElforbrugkWtAar');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP elforbrugkWtAar, DROP nytElforbrugkWtAar');
    }
}
