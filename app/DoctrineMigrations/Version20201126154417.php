<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201126154417 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ReportText ADD standard_virk_energisyn TINYINT(1) DEFAULT NULL, ADD standard_virk_screening TINYINT(1) DEFAULT NULL, ADD standard_virk_detailark TINYINT(1) DEFAULT NULL');
        $this->addSql('UPDATE ReportText SET standard_virk_energisyn = 1, standard_virk_screening = 1, standard_virk_detailark = 1 WHERE standard = 1');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ReportText DROP standard_virk_energisyn, DROP standard_virk_screening, DROP standard_virk_detailark');
    }
}
