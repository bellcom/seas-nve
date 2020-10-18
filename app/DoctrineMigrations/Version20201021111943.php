<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201021111943 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE RapportSektion (id INT AUTO_INCREMENT NOT NULL, bygning_oversigt_rapport_id INT DEFAULT NULL, virksomhed_oversigt_rapport_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, extras LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', discr VARCHAR(255) NOT NULL, INDEX IDX_87A25A2371A1B7A (bygning_oversigt_rapport_id), INDEX IDX_87A25A23CB830CE3 (virksomhed_oversigt_rapport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE RapportSektion ADD CONSTRAINT FK_87A25A2371A1B7A FOREIGN KEY (bygning_oversigt_rapport_id) REFERENCES Rapport (id)');
        $this->addSql('ALTER TABLE RapportSektion ADD CONSTRAINT FK_87A25A23CB830CE3 FOREIGN KEY (virksomhed_oversigt_rapport_id) REFERENCES VirksomhedRapport (id)');
        $this->addSql('ALTER TABLE ReportText DROP type, DROP standard');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE RapportSektion');
        $this->addSql('ALTER TABLE ReportText ADD type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD standard TINYINT(1) DEFAULT NULL');
    }
}
