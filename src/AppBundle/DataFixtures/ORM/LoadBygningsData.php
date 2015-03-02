<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Ddeboer\DataImport\ValueConverter\CharsetValueConverter;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Ddeboer\DataImport\ValueConverter\MappingValueConverter;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadBygningsData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadBygningsData implements FixtureInterface, ContainerAwareInterface {
  /**
   * @var ContainerInterface
   */
  private $container;

  /**
   * {@inheritDoc}
   */
  public function setContainer(ContainerInterface $container = NULL) {
    $this->container = $container;
  }

  /**
   * {@inheritDoc}
   */
  public function load(ObjectManager $manager) {
    $basepath = $this->container->get('kernel')
      ->locateResource('@AppBundle/DataFixtures/Data/');
    $filename = 'BygningsData.csv';

    $output = new ConsoleOutput();

    if (file_exists($basepath . $filename)) {
      // Create and configure the reader
      $file = new \SplFileObject($basepath . $filename);
      $csvReader = new CsvReader($file, ';');
      $progressWriter = new ConsoleProgressWriter($output, $csvReader, 'normal', 100);

      // Tell the reader that the first row in the CSV file contains column headers
      $csvReader->setHeaderRowNumber(0);

      // Create the workflow from the reader
      $workflow = new Workflow($csvReader);
      $workflow->addMapping('Id', 'bygId');
      $workflow->addMapping('Ident', 'ident');
      $workflow->addMapping('Enhedsys', 'enhedsys');
      $workflow->addMapping('Enhedskode', 'enhedskode');
      $workflow->addMapping('Type', 'type');
      $workflow->addMapping('Kommentarer', 'kommentarer');
      $workflow->addMapping('Adresse', 'adresse');
      $workflow->addMapping('Postnr', 'postnummer');
      $workflow->addMapping('POSTBY', 'postBy');

      $workflow->addValueConverter('type', new CharsetValueConverter('utf8', 'latin1'));
      $workflow->addValueConverter('kommentarer', new CharsetValueConverter('utf8', 'latin1'));
      $workflow->addValueConverter('adresse', new CharsetValueConverter('utf8', 'latin1'));
      $workflow->addValueConverter('postBy', new CharsetValueConverter('utf8', 'latin1'));

      // Create a writer: you need Doctrine’s EntityManager.
      $doctrineWriter = new DoctrineWriter($manager, 'AppBundle:Bygning');
      $workflow->addWriter($doctrineWriter);

      $workflow->addWriter($progressWriter);

      // Process the workflow

      $workflow->process();

      $output->writeln('');
      $output->writeln('  <comment>></comment> <info>' . $filename . ' imported succesfully</info>');
    }
    else {
      $output->writeln('  <comment>></comment> <error>' . $filename . ' not found. Did you forget to add it to AppBundle/DataFixtures/Data?</error>');
    }
  }
}
