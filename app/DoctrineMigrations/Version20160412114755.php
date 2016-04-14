<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160412114755 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql("UPDATE TiltagDetail_audit detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Pir i afbryder') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'pir_i_afbryder' ");
    $this->addSql("UPDATE TiltagDetail_audit detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Pir on/off centralt') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'pir_on_off' ");
    $this->addSql("UPDATE TiltagDetail_audit detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Pir/DGS centralt') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'pir_dgs' ");
    $this->addSql("UPDATE TiltagDetail_audit detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Skumringsrelæ') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'skumringsrelae' ");
    $this->addSql("UPDATE TiltagDetail_audit detail, (SELECT * FROM BelysningTiltagDetail_NyStyring WHERE titel = 'Andet, se noter') styring SET detail.nyStyring_id = styring.id WHERE detail.styring = 'andet_se_noter' ");

    $this->addSql("UPDATE TiltagDetail_audit SET styring = NULL");

    $this->addSql('ALTER TABLE TiltagDetail CHANGE styring styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COMMENT \'(DC2Type:StyringType)\'');
    $this->addSql('ALTER TABLE TiltagDetail_audit CHANGE styring styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COMMENT \'(DC2Type:StyringType)\'');
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE TiltagDetail CHANGE styring styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:StyringType)\'');
    $this->addSql('ALTER TABLE TiltagDetail_audit CHANGE styring styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:StyringType)\'');
  }
}
