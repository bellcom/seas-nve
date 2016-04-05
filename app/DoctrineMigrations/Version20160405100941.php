<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160405100941 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE Tiltag change column anlaegsinvesteringExRisiko anlaegsinvesteringExRisiko DOUBLE after reelAnlaegsinvestering;');
    $this->addSql('ALTER TABLE Tiltag change column anlaegsinvestering_beregnet anlaegsinvestering_beregnet DOUBLE after anlaegsinvesteringExRisiko;');
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs

  }
}
