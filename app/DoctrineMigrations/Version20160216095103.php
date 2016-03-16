<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Ensure we don't have invalid references between bygning and users
 */
class Version20160216095103 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs

    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('UPDATE Bygning b SET b.energiraadgiver_id = NULL WHERE b.energiraadgiver_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM fos_user u WHERE b.energiraadgiver_id = u.id)');
    $this->addSql('UPDATE Bygning b SET b.aaplusansvarlig_id = NULL WHERE b.aaplusansvarlig_id IS NOT NULL AND NOT EXISTS (SELECT 1 FROM fos_user u WHERE b.aaplusansvarlig_id = u.id)');
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs

  }
}
