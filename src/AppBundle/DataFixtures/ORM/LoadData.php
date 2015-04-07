<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\ConsoleProgressWriter;
use Ddeboer\DataImport\Writer\WriterInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
abstract class LoadData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {
  public function __construct() {
    $this->output = new ConsoleOutput();
  }

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

  final protected function writeInfo($message) {
    if (func_num_args() > 1) {
      $message = call_user_func_array('sprintf', func_get_args());
    }
    $this->output->writeln('');
    $this->output->writeln('  <comment>></comment> <info>' . $message . '</info>');
  }

  final protected function writeError($message) {
    if (func_num_args() > 1) {
      $message = call_user_func_array('sprintf', func_get_args());
    }
    $this->output->writeln('');
    $this->output->writeln('  <comment>></comment> <error>' . $message . '</error>');
  }

  protected function getFilename() {
    $ancestor = get_parent_class($this);
    while ($ancestor && $ancestor instanceof LoadData) {
      $ancestor = get_parent_class($ancestor);
    }

    if (!$ancestor) {
      $ancestor = get_class($this);
    }

    $ancestorNamespace = substr($ancestor, 0, strrpos($ancestor, '\\'));
    if (strpos(get_class($this), $ancestorNamespace) === 0) {
      $path = substr(get_class($this), strlen($ancestorNamespace)+1);
    }

    return preg_replace(array('@\\\\Load@', '@^Load@', '@\\\\@'), array('\\', '', '/'), $path).'.csv';
  }

  protected $order = 1;
  protected $flush = true;

  /**
   * @param ObjectManager $manager
   * @return WriterInterface
   */
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
