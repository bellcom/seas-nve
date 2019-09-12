<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190911121614 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE energiraadgiver_user (bygning_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1C4D78905D371389 (bygning_id), INDEX IDX_1C4D7890A76ED395 (user_id), PRIMARY KEY(bygning_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE energiraadgiver_user ADD CONSTRAINT FK_1C4D78905D371389 FOREIGN KEY (bygning_id) REFERENCES Bygning (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE energiraadgiver_user ADD CONSTRAINT FK_1C4D7890A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Bygning DROP FOREIGN KEY FK_FD908E37AD412CA4');
        $this->addSql('DROP INDEX IDX_FD908E37AD412CA4 ON Bygning');
        $this->addSql('ALTER TABLE Bygning DROP energiraadgiver_id');
        $this->addSql('ALTER TABLE Bygning_audit DROP energiraadgiver_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE energiraadgiver_user');
        $this->addSql('ALTER TABLE Bygning ADD energiraadgiver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Bygning ADD CONSTRAINT FK_FD908E37AD412CA4 FOREIGN KEY (energiraadgiver_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_FD908E37AD412CA4 ON Bygning (energiraadgiver_id)');
        $this->addSql('ALTER TABLE Bygning_audit ADD energiraadgiver_id INT DEFAULT NULL');
    }
}
