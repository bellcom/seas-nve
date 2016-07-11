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
  }

  /**
   * Recalculate Rapport to update properties depending of the values updated.
   *
   * @param Schema $schema
   */
  public function postUp(Schema $schema) {
    $em = $this->container->get('doctrine.orm.entity_manager');
    $repository = $em->getRepository('AppBundle:Rapport');
    $rapporter = $repository->findAll();

    $reflectionClass = null;

    foreach ($rapporter as $rapport) {
      if ($reflectionClass === null) {
        $reflectionClass = new ReflectionClass(get_class($rapport));
      }

      $oldBesparelseVarmeGUF = floatval($rapport->getBesparelseVarmeGUF());
      $oldBesparelseVarmeGAF = floatval($rapport->getBesparelseVarmeGAF());
      $oldFravalgtBesparelseVarmeGUF = floatval($rapport->getFravalgtBesparelseVarmeGUF());
      $oldFravalgtBesparelseVarmeGAF = floatval($rapport->getFravalgtBesparelseVarmeGAF());

      $rapport->calculate();

      $newBesparelseVarmeGUF = floatval($rapport->getBesparelseVarmeGUF());
      $newBesparelseVarmeGAF = floatval($rapport->getBesparelseVarmeGAF());
      $newFravalgtBesparelseVarmeGUF = floatval($rapport->getFravalgtBesparelseVarmeGUF());
      $newFravalgtBesparelseVarmeGAF = floatval($rapport->getFravalgtBesparelseVarmeGAF());

      $changedValues = [];
      if ($newBesparelseVarmeGUF != $oldBesparelseVarmeGUF) {
        $changedValues['besparelseVarmeGUF'] = [
          'old' => $oldBesparelseVarmeGUF,
          'new' => $newBesparelseVarmeGUF,
        ];
      }
      if ($newBesparelseVarmeGAF != $oldBesparelseVarmeGAF) {
        $changedValues['besparelseVarmeGAF'] = [
          'old' => $oldBesparelseVarmeGAF,
          'new' => $newBesparelseVarmeGAF,
        ];
      }
      if ($newFravalgtBesparelseVarmeGUF != $oldFravalgtBesparelseVarmeGUF) {
        $changedValues['fravalgtBesparelseVarmeGUF'] = [
          'old' => $oldFravalgtBesparelseVarmeGUF,
          'new' => $newFravalgtBesparelseVarmeGUF,
        ];
      }
      if ($newFravalgtBesparelseVarmeGAF != $oldFravalgtBesparelseVarmeGAF) {
        $changedValues['fravalgtBesparelseVarmeGAF'] = [
          'old' => $oldFravalgtBesparelseVarmeGAF,
          'new' => $newFravalgtBesparelseVarmeGAF,
        ];
      }

      if ($changedValues) {
        foreach ($changedValues as $name => $values) {
          $property = $reflectionClass->getProperty($name);
          $property->setAccessible(true);
          $property->setValue($rapport, $values['new']);
        }
        $em->persist($rapport);

        $this->write(sprintf('rapport %d: %s', $rapport->getId(), var_export($changedValues, true)));
      }
    }
  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
  }
}
