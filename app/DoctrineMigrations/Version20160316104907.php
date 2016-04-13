<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160316104907 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline ADD bygning_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB1105D371389 FOREIGN KEY (bygning_id) REFERENCES Bygning (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6FB1105D371389 ON Baseline (bygning_id)');
        $this->addSql('ALTER TABLE Bygning DROP FOREIGN KEY FK_FD908E37DC280AA8');
        $this->addSql('DROP INDEX UNIQ_FD908E37DC280AA8 ON Bygning');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP FOREIGN KEY FK_F6FB1105D371389');
        $this->addSql('DROP INDEX UNIQ_F6FB1105D371389 ON Baseline');
        $this->addSql('ALTER TABLE Baseline DROP bygning_id');
    }
}
