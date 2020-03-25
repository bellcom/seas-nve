<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200325164853 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD varmebespKrAar DOUBLE PRECISION DEFAULT NULL, ADD elbespKrAar DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD varmebespKrAar DOUBLE PRECISION DEFAULT NULL, ADD elbespKrAar DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP varmebespKrAar, DROP elbespKrAar');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP varmebespKrAar, DROP elbespKrAar');
    }
}
