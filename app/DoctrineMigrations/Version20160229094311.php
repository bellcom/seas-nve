<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160229094311 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE BelysningTiltagDetail_NyStyring ADD deleted_at DATETIME DEFAULT NULL');

    $this->addSql("INSERT INTO BelysningTiltagDetail_NyStyring (titel, deleted_at) VALUES
                      ('Pir i afbryder', NOW()),
                      ('Pir on/off centralt', NOW()),
                      ('Pir/DGS centralt', NOW()),
                      ('Skumringsrelæ', NOW()),
                      ('Andet, se noter', NOW())
                      ");

    $this->addSql("UPDATE TiltagDetail detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Pir i afbryder') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'pir_i_afbryder' ");
    $this->addSql("UPDATE TiltagDetail detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Pir on/off centralt') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'pir_on_off' ");
    $this->addSql("UPDATE TiltagDetail detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Pir/DGS centralt') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'pir_dgs' ");
    $this->addSql("UPDATE TiltagDetail detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Skumringsrelæ') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'skumringsrelae' ");
    $this->addSql("UPDATE TiltagDetail detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Andet, se noter') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'andet_se_noter' ");

    $this->addSql("UPDATE TiltagDetail SET styring = NULL");
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE BelysningTiltagDetail_NyStyring DROP deleted_at');
  }
}
