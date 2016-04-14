<?php
namespace AppBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class PostMigrateCommand extends ContainerAwareCommand {
  protected function configure() {
    $this
      ->setName('aaplus:post-migrate')
      ->setDescription('Run code after doctrine migrations');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    // Call methods that should be run after all migrations.
    //
    // The methods MUST ONLY add data in empty fields, i.e. fields that have
    // been added by a (recent) migration.
    $this->Version20160405162034();
  }

  /**
   * Calculate and persist cash flow for all Rapport entities having an empty cash flow.
   */
  private function Version20160405162034() {
    echo __METHOD__, PHP_EOL;

    $doctrine = $this->getContainer()->get('doctrine');
    $em = $doctrine->getEntityManager('default');

    $rapporter = $doctrine->getRepository('AppBundle:Rapport')->findAll();
    $sql = 'UPDATE Rapport SET cashFlow = :cashFlow where id = :id';
    $stm = $em->getConnection()->prepare($sql);
    foreach ($rapporter as $rapport) {
      $cashFlow = $rapport->getCashFlow();
      if (!$cashFlow) {
        $rapport->calculate();
        $stm->bindValue('id', $rapport->getId());
        $stm->bindValue('cashFlow', serialize($rapport->getCashFlow()));
        $stm->execute();
      }
    }
  }
}
