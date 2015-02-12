<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Writer\DoctrineWriter;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\Tiltag;

class LoadTiltagsData implements FixtureInterface, ContainerAwareInterface
{

	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * {@inheritDoc}
	 */
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$em = $this->container->get('doctrine')->getManager();
		$basepath = $this->container->get('kernel')->locateResource('@AppBundle/DataFixtures/Data/');
		$filename = 'TiltagsData.csv';

		$output = new ConsoleOutput();

		if(file_exists($basepath.$filename)) {

			// Create and configure the reader
			$file = new \SplFileObject($basepath.$filename);
			$csvReader = new CsvReader($file, ';');

			// Tell the reader that the first row in the CSV file contains column headers
			$csvReader->setHeaderRowNumber(0);

			// Create the workflow from the reader
			$workflow = new Workflow($csvReader);

			// Create a writer: you need Doctrine’s EntityManager.
			$doctrineWriter = new DoctrineWriter($em, 'AppBundle:Tiltag');

			$workflow->addWriter($doctrineWriter);

			// Process the workflow
			$result = $workflow->process();

			$output->writeln('  <comment>></comment> <info> - '.$filename.' imported succesfully</info>');
		} else {
			$output->writeln('  <comment>></comment> <error>'.$filename.' not found. Did you forget to add it to AppBundle/DataFixtures/Data?</error>');
		}
	}
}
