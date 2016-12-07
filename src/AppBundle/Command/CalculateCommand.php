<?php
namespace AppBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class CalculateCommand extends ContainerAwareCommand {
  protected function configure() {
    $this
      ->setName('aaplus:calculate')
      ->setDescription('Calculate entities')
      ->addArgument(
        'entity',
        InputArgument::REQUIRED | InputArgument::IS_ARRAY,
        'What do you want to calculate? Format: «type»[:«id»]'
      )
      ->addOption(
        'persist',
        null,
        InputOption::VALUE_NONE,
        'If set, the calculated values will be persisted'
      );
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $entities = $this->getEntities($input);

    $em = $this->getContainer()->get('doctrine')->getManager('default');

    foreach ($entities as $entity) {
      $originalValues = $this->getValues($entity);

      $output->writeln('Calculating ' . get_class($entity) . ':' . $entity->getId());
      $entity->calculate();

      $calculatedValues = $this->getValues($entity);

      // $output->writeln(Yaml::dump($originalValues));
      // $output->writeln(Yaml::dump($calculatedValues));
      // $output->writeln(Yaml::dump($this->array_diff_assoc_recursive($originalValues, $calculatedValues)));

      // $difference = $this->array_diff_assoc_recursive($originalValues, $calculatedValues);
      // foreach ($difference as $key => $_) {
      //   $output->writeln($key . ': ' . var_export($originalValues[$key], true) . ' -> ' . var_export($calculatedValues[$key], true));
      // }

      if ($input->getOption('persist')) {
        $output->writeln('Persisting ' . get_class($entity) . ':' . $entity->getId());
        $em->persist($entity);
      }
    }
    $em->flush();
  }

  private function getValues($entity) {
    $class = new \ReflectionClass($entity);
    $getters = array_filter($class->getMethods(\ReflectionMethod::IS_PUBLIC), function($method) {
      return preg_match('/^get/', $method->name);
    });

    $values = [];

    foreach ($getters as $getter) {
      $name = preg_replace('/^get/', '', $getter->name);
      $value = $getter->invoke($entity);
      if (!is_object($value)) {
        $values[$name] = $value;
      }
    }

    return $values;
  }

  private function getEntities(InputInterface $input) {
    $entities = new ArrayCollection();

    $specs = $input->getArgument('entity');
    foreach ($specs as $spec) {
      $tokens = explode(':', $spec);
      $type = count($tokens) > 0 ? $tokens[0] : NULL;
      $id = count($tokens) > 1 ? $tokens[1] : NULL;

      $em = $this->getContainer()->get('doctrine')->getManager('default');
      if ($id) {
        $query = $em->createQuery('SELECT e FROM AppBundle:' . $type . ' e WHERE e.id = :id');
        $query->setParameter('id', $id);
      }
      else {
        $query = $em->createQuery('SELECT e FROM AppBundle:' . $type . ' e');
      }

      $result = $query->getResult();
      foreach ($result as $entity) {
        $entities->add($entity);
      }
    }

    return $entities;
  }

  private function array_diff_assoc_recursive($array1, $array2) {
    $difference=array();
    foreach($array1 as $key => $value) {
      if( is_array($value) ) {
        if( !isset($array2[$key]) || !is_array($array2[$key]) ) {
                $difference[$key] = $value;
            } else {
                $new_diff = $this->array_diff_assoc_recursive($value, $array2[$key]);
                if( !empty($new_diff) )
                    $difference[$key] = $new_diff;
            }
        } else if( !array_key_exists($key,$array2) || $array2[$key] !== $value ) {
            $difference[$key] = $value;
        }
    }
    return $difference;
  }

}
