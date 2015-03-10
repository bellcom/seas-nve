<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Ddeboer\DataImport\ValueConverter\CharsetValueConverter;
use Ddeboer\DataImport\ValueConverter\CallbackValueConverter;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;

use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Ddeboer\DataImport\ValueConverter\MappingValueConverter;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Ddeboer\DataImport\Writer\CallbackWriter;

use Symfony\Component\Console\Output\ConsoleOutput;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\User;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
abstract class LoadData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {
  /**
   * @var ContainerInterface
   */
  protected $container;

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
    $basepath = $this->container->get('kernel')->locateResource('@AppBundle/DataFixtures/Data/');
    $filename = $this->getFilename();

    $this->output = new ConsoleOutput();

    if (file_exists($basepath . $filename)) {
      // Create and configure the reader
      $file = new \SplFileObject($basepath . $filename);
      $csvReader = new CsvReader($file, ';');
      $progressWriter = new ConsoleProgressWriter($this->output, $csvReader, 'normal', 100);

      // Tell the reader that the first row in the CSV file contains column headers
      $csvReader->setHeaderRowNumber(0);

      // Create the workflow from the reader
      $workflow = new Workflow($csvReader);

      $workflow->addWriter($this->createWriter($manager));
      $workflow->addWriter($progressWriter);

      // Process the workflow

      $workflow->process();
      $this->done($manager);

      $this->writeInfo($filename . ' imported succesfully');
    }
    else {
      $this->writeError($filename . ' not found. Did you forget to add it to AppBundle/DataFixtures/Data?');
    }
  }

  /** @var ConsoleOutput $output */
  private $output = null;

  protected final function writeInfo($message) {
    $this->output->writeln('');
    $this->output->writeln('  <comment>></comment> <info>' . $message . '</info>');
  }

  protected final function writeError($message) {
    $this->output->writeln('');
    $this->output->writeln('  <comment>></comment> <error>' . $message . '</error>');
  }

  protected function getFilename() {
    $className = get_class($this);
    $index = strrpos($className, '\\');
    $filename = $index === false ? $className : substr($className, $index+5). '.csv';
    return $filename;
  }

  protected $order = 1;
  protected $flush = false;

  abstract protected function createWriter(ObjectManager $manager);

  protected function done(ObjectManager $manager) {
    if ($this->flush) {
      $manager->flush();
    }
  }

  /**
   * {@inheritDoc}
   */
  public function getOrder() {
    return $this->order;
  }
}
