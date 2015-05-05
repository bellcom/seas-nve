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
 * Class LoadPumpeData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadPumpeData implements FixtureInterface, ContainerAwareInterface {
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
  public function load(ObjectManager $manager) { return;
    $basepath = $this->container->get('kernel')
      ->locateResource('@AppBundle/DataFixtures/Data/');
    $filename = 'PumpelistenData.csv';

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

      // Mapping headers (CSV, DB)

      //Post;Type;Byggemaal;Tilslutning;Indst;Forbrug;Q;H;Aarsforbrug;NyPumpe;ByggemaalNy;TilslutningNy;Vvsnr;AarsforbrugNy;elbespar;Udligning;kommentarer;Standardinvestering;Roerlaengde;Roerstoerrelse;Fabrikant;;;;;

      $workflow->addMapping('Post', 'id');
      $workflow->addMapping('Type', 'nuvaerendeType');
      $workflow->addMapping('Byggemaal', 'byggemaal');
      $workflow->addMapping('Tilslutning', 'tilslutning');
      $workflow->addMapping('Indst', 'indst');
      $workflow->addMapping('Forbrug', 'forbrug');
      $workflow->addMapping('Q', 'q');
      $workflow->addMapping('H', 'h');
      $workflow->addMapping('Aarsforbrug', 'aarsforbrug');
      $workflow->addMapping('NyPumpe', 'nyPumpe');
      $workflow->addMapping('NyByggemaal', 'nyByggemaal');
      $workflow->addMapping('NyTilslutning', 'nyTilslutning');
      $workflow->addMapping('Vvsnr', 'vvsnr');
      $workflow->addMapping('AarsforbrugNy', 'nytAarsforbrug');
      $workflow->addMapping('elbespar', 'elbesparelse');
      $workflow->addMapping('Udligning', 'udligningssaet');
      $workflow->addMapping('kommentarer', 'kommentarer');
      $workflow->addMapping('Standardinvestering', 'standInvestering');
      $workflow->addMapping('Roerlaengde', 'roerlaengde');
      $workflow->addMapping('Roerstoerrelse', 'roerstoerrelse');
      $workflow->addMapping('Fabrikant', 'fabrikant');

      $workflow->addValueConverter('tilslutning', new CharsetValueConverter('utf8', 'latin1'));
      $workflow->addValueConverter('nyTilslutning', new CharsetValueConverter('utf8', 'latin1'));
      $workflow->addValueConverter('kommentarer', new CharsetValueConverter('utf8', 'latin1'));
      $workflow->addValueConverter('roerstoerrelse', new CharsetValueConverter('utf8', 'latin1'));

      // Create a writer: you need Doctrine’s EntityManager.
      $doctrineWriter = new DoctrineWriter($manager, 'AppBundle:Pumpe');
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
