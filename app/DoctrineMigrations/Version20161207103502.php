<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161207103502 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD solcelleproduktion NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD solcelleproduktion NUMERIC(14, 4) DEFAULT NULL');

        $this->addSql("UPDATE Tiltag SET solcelleproduktion = elbesparelse, elbesparelse = 0 WHERE discr = 'solcelle'");
        $this->addSql("UPDATE Tiltag_audit SET solcelleproduktion = elbesparelse, elbesparelse = 0 WHERE discr = 'solcelle'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("UPDATE Tiltag SET elbesparelse = solcelleproduktion WHERE discr = 'solcelle'");
        $this->addSql("UPDATE Tiltag_audit SET elbesparelse = solcelleproduktion WHERE discr = 'solcelle'");

        $this->addSql('ALTER TABLE Tiltag DROP solcelleproduktion');
        $this->addSql('ALTER TABLE Tiltag_audit DROP solcelleproduktion');
    }
}
