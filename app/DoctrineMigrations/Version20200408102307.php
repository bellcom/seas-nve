<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200408102307 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD tilstandDataFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tilstandDataEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD etotReduktion DOUBLE PRECISION DEFAULT NULL, ADD samletBesparelse DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD tilstandDataFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD tilstandDataEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD etotReduktion DOUBLE PRECISION DEFAULT NULL, ADD samletBesparelse DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP tilstandDataFoer, DROP tilstandDataEfter, DROP etotReduktion, DROP samletBesparelse');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP tilstandDataFoer, DROP tilstandDataEfter, DROP etotReduktion, DROP samletBesparelse');
    }
}
