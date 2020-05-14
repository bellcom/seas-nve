<?php

namespace AppBundle\Command;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AuditEntitiesCleanupCommand extends ContainerAwareCommand {

  protected function configure() {
    $this->setName('seas-nve:audit-entities-cleanup')
      ->setDescription('Deleting deleted entities records from audit table.');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    /** @var \AppBundle\EntityAudit\AuditManager $auditManager */
    $auditManager = $this->getContainer()
      ->get('simplethings_entityaudit.manager');

    /** @var \Doctrine\ORM\EntityManagerInterface $em */
    $em = $this->getContainer()->get('doctrine')->getManager('default');

    /** @var \SimpleThings\EntityAudit\AuditConfiguration $auditConfig */
    $auditConfig = $auditManager->getConfiguration();

    $revtypeField = $auditConfig->getRevisionTypeFieldName();
    $revisionTable = $auditConfig->getRevisionTableName();

    /** @var \SimpleThings\EntityAudit\Metadata\MetadataFactory $metadataFactory */
    $metadataFactory = $auditManager->getMetadataFactory();
    $auditedEntities = $metadataFactory->getAllClassNames();

    if (empty($auditedEntities)) {
      $output->writeln('No entities are being audited. Skipping');
      return;
    }

    foreach ($auditedEntities AS $className) {
      /** @var ClassMetadataInfo|ClassMetadata $class */
      $class = $em->getClassMetadata($className);
      $tableName = $auditConfig->getTableName($class);

      $output->writeln('Cleaning up ' . $tableName);

      $result = $em->getConnection()
        ->fetchAll("SELECT t.id FROM $tableName t WHERE $revtypeField = ?", array('DEL'));
      $deletedEntitesIds = array_column($result, 'id');

      if (!empty($deletedEntitesIds)) {
        $result = $em->getConnection()
          ->fetchAll("SELECT t.rev FROM $tableName t WHERE id IN (" . implode(',', $deletedEntitesIds) . ")");

        $deletedRevisionIds = array_column($result, 'rev');

        if (!empty($deletedRevisionIds)) {
          // Remove data from revision table
          $output->writeln('Cleaning revision table');
          $em->getConnection()
            ->query("DELETE FROM $revisionTable WHERE id IN (" . implode(',', $deletedRevisionIds) . ")");
        }

        // Remove data from audit table
        $output->writeln('Cleaning audit table');
        $em->getConnection()
          ->query("DELETE FROM $tableName WHERE id IN (" . implode(',', $deletedEntitesIds) . ")");

        $output->writeln('Done');
      }
      else {
        $output->writeln('Nothing to clean. Skipping.');
      }
      $output->writeln('---');
    }
  }

}
