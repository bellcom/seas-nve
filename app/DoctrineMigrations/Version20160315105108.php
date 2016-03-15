<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160315105108 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // Copy data from typePlaceringJfPlantegning to type.
        $this->addSql('UPDATE TiltagDetail SET type = typePlaceringJfPlantegning, placering = \'\' WHERE discr = \'vindue\' or discr like \'klimask_rm\'');
        $this->addSql('UPDATE TiltagDetail_audit SET type = typePlaceringJfPlantegning, placering = \'\' WHERE discr = \'vindue\' or discr like \'klimask_rm\'');

        $this->addSql('ALTER TABLE TiltagDetail DROP typePlaceringJfPlantegning');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP typePlaceringJfPlantegning');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD typePlaceringJfPlantegning VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD typePlaceringJfPlantegning VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');

        // Copy data from type to typePlaceringJfPlantegning.
        $this->addSql('UPDATE TiltagDetail SET typePlaceringJfPlantegning = type, type = \'\' WHERE discr = \'vindue\' or discr like \'klimask_rm\'');
        $this->addSql('UPDATE TiltagDetail_audit SET typePlaceringJfPlantegning = type, type = \'\' WHERE discr = \'vindue\' or discr like \'klimask_rm\'');
    }
}
