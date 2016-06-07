<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160607130300 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql("ALTER TABLE Baseline MODIFY COLUMN arealdataSekundaerKilde ENUM('Ingen sekundær kilde vurderes nødvendig', 'ingen_sekundaer_kilde_vurderes_noedvendig', 'caretaker', 'tegningsfiler_i_kontainer', 'bbr_meddelelse', 'bygningskonsulent_ved_aak', 'mark_kontrol') DEFAULT NULL");
    $this->addSql("UPDATE Baseline SET arealdataSekundaerKilde = 'ingen_sekundaer_kilde_vurderes_noedvendig' WHERE arealdataSekundaerKilde = 'Ingen sekundær kilde vurderes nødvendig' ");
    $this->addSql("ALTER TABLE Baseline MODIFY COLUMN arealdataSekundaerKilde ENUM('ingen_sekundaer_kilde_vurderes_noedvendig', 'caretaker', 'tegningsfiler_i_kontainer', 'bbr_meddelelse', 'bygningskonsulent_ved_aak', 'mark_kontrol') DEFAULT NULL");

    $this->addSql("ALTER TABLE Baseline_audit MODIFY COLUMN arealdataSekundaerKilde ENUM('Ingen sekundær kilde vurderes nødvendig', 'ingen_sekundaer_kilde_vurderes_noedvendig', 'caretaker', 'tegningsfiler_i_kontainer', 'bbr_meddelelse', 'bygningskonsulent_ved_aak', 'mark_kontrol') DEFAULT NULL");
    $this->addSql("UPDATE Baseline_audit SET arealdataSekundaerKilde = 'ingen_sekundaer_kilde_vurderes_noedvendig' WHERE arealdataSekundaerKilde = 'Ingen sekundær kilde vurderes nødvendig' ");
    $this->addSql("ALTER TABLE Baseline_audit MODIFY COLUMN arealdataSekundaerKilde ENUM('ingen_sekundaer_kilde_vurderes_noedvendig', 'caretaker', 'tegningsfiler_i_kontainer', 'bbr_meddelelse', 'bygningskonsulent_ved_aak', 'mark_kontrol') DEFAULT NULL");
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
  }
}
