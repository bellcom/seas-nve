<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225094202 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Baseline (id INT AUTO_INCREMENT NOT NULL, bygning_id INT DEFAULT NULL, elo_kategori_id INT DEFAULT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, UNIQUE INDEX UNIQ_F6FB1105D371389 (bygning_id), INDEX IDX_F6FB110F435B649 (elo_kategori_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ELOFordeling (id INT AUTO_INCREMENT NOT NULL, januar DOUBLE PRECISION NOT NULL, februar DOUBLE PRECISION NOT NULL, marts DOUBLE PRECISION NOT NULL, april DOUBLE PRECISION NOT NULL, maj DOUBLE PRECISION NOT NULL, juni DOUBLE PRECISION NOT NULL, juli DOUBLE PRECISION NOT NULL, august DOUBLE PRECISION NOT NULL, september DOUBLE PRECISION NOT NULL, oktober DOUBLE PRECISION NOT NULL, november DOUBLE PRECISION NOT NULL, december DOUBLE PRECISION NOT NULL, eloKategoriFordelingVarmeGUF_id INT DEFAULT NULL, eloKategoriFordelingVarmeGAF_id INT DEFAULT NULL, eloKategoriFordelingEl_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_63AB67A52C484233 (eloKategoriFordelingVarmeGUF_id), UNIQUE INDEX UNIQ_63AB67A5B9287371 (eloKategoriFordelingVarmeGAF_id), UNIQUE INDEX UNIQ_63AB67A55F512B8C (eloKategoriFordelingEl_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ELOKategori (id INT AUTO_INCREMENT NOT NULL, createdBy VARCHAR(255) DEFAULT NULL, updatedBy VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, updatedAt DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB1105D371389 FOREIGN KEY (bygning_id) REFERENCES Bygning (id)');
        $this->addSql('ALTER TABLE Baseline ADD CONSTRAINT FK_F6FB110F435B649 FOREIGN KEY (elo_kategori_id) REFERENCES ELOKategori (id)');
        $this->addSql('ALTER TABLE ELOFordeling ADD CONSTRAINT FK_63AB67A52C484233 FOREIGN KEY (eloKategoriFordelingVarmeGUF_id) REFERENCES ELOKategori (id)');
        $this->addSql('ALTER TABLE ELOFordeling ADD CONSTRAINT FK_63AB67A5B9287371 FOREIGN KEY (eloKategoriFordelingVarmeGAF_id) REFERENCES ELOKategori (id)');
        $this->addSql('ALTER TABLE ELOFordeling ADD CONSTRAINT FK_63AB67A55F512B8C FOREIGN KEY (eloKategoriFordelingEl_id) REFERENCES ELOKategori (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP FOREIGN KEY FK_F6FB110F435B649');
        $this->addSql('ALTER TABLE ELOFordeling DROP FOREIGN KEY FK_63AB67A52C484233');
        $this->addSql('ALTER TABLE ELOFordeling DROP FOREIGN KEY FK_63AB67A5B9287371');
        $this->addSql('ALTER TABLE ELOFordeling DROP FOREIGN KEY FK_63AB67A55F512B8C');
        $this->addSql('DROP TABLE Baseline');
        $this->addSql('DROP TABLE ELOFordeling');
        $this->addSql('DROP TABLE ELOKategori');
    }
}
