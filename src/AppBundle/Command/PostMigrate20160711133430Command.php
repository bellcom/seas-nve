<?php
namespace AppBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class PostMigrate20160711133430Command extends ContainerAwareCommand {
  protected function configure() {
    $this
      ->setName('aaplus:post-migrate:20160711133430')
      ->setDescription('Run code after doctrine migration 20160711133430');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->Version20160711133430();
  }

  /**
   * Recalculate Rapport to update properties depending of the values updated.
   */
  private function Version20160711133430() {
    echo __METHOD__, PHP_EOL;

    $doctrine = $this->getContainer()->get('doctrine');
    $em = $doctrine->getEntityManager('default');
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

        echo sprintf('rapport %d: %s', $rapport->getId(), var_export($changedValues, true)), PHP_EOL;
      }
    }
  }
}
