<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160711133430 extends AbstractMigration implements ContainerAwareInterface {
  private $container;

  public function setContainer(ContainerInterface $container = null) {
    $this->container = $container;
  }

  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    // Move value from varmebesparelseGUF to varmebesparelseGAF and set varmebesparelseGUF to null (which the value will always be).
    $this->addSql("UPDATE Tiltag SET varmebesparelseGAF = varmebesparelseGUF, varmebesparelseGUF = NULL where discr = 'belysning';");
    $this->addSql("UPDATE Tiltag_audit SET varmebesparelseGAF = varmebesparelseGUF, varmebesparelseGUF = NULL where discr = 'belysning';");

    $this->write('

<comment>Please run

app/console aaplus:post-migrate:20160711133430

to flip gaf and guf after migrations have run.</comment>

');
    readline('Capisce? ');
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
  }
}
