<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class DatabaseCommand extends ContainerAwareCommand {
  protected function configure() {
    $this
      ->setName('aaplus:database')
      ->setDescription('Database stuff')
      ->addArgument(
        'action',
        InputArgument::REQUIRED,
        'What do you want to do? (cli|dump)'
      );
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $action = $input->getArgument('action');

    if (method_exists($this, $action)) {
      $this->{$action}($input);
    } else {
      throw new \Exception('Invalid action: ' . $action);
    }
  }

  /**
   * @deprecated Deprecated – use "cli".
   */
  private function connect() {
    $STDERR = fopen('php://stderr', 'w+');
    fwrite($STDERR, PHP_EOL . 'Command "connect" is deprecated. Use "cli" instead, i.e. app/console aaplus:database cli.' . PHP_EOL . PHP_EOL);
    $this->cli();
  }

  private function cli() {
    $parameters = $this->getContainer()->getParameterBag();
    $cmd = 'mysql'
         .' --host=' . escapeshellarg($parameters->get('database_host'))
         .' --user=' . escapeshellarg($parameters->get('database_user'))
         .' --password=' . escapeshellarg($parameters->get('database_password'))
         .' --database=' . escapeshellarg($parameters->get('database_name'));

    $pipes = [];
    $process = proc_open($cmd, [ 0 => STDIN, 1 => STDOUT, 2 => STDERR ], $pipes);
    $proc_status = proc_get_status($process);
    $exit_code = proc_close($process);
    exit ($proc_status["running"] ? $exit_code : $proc_status["exitcode"]);
  }

  private function dump() {
    $parameters = $this->getContainer()->getParameterBag();
    $cmd = 'mysqldump --skip-extended-insert --complete-insert'
         .' --host=' . escapeshellarg($parameters->get('database_host'))
         .' --user=' . escapeshellarg($parameters->get('database_user'))
         .' --password=' . escapeshellarg($parameters->get('database_password'))
         .' ' . escapeshellarg($parameters->get('database_name'));

    $pipes = [];
    $process = proc_open($cmd, [ 0 => STDIN, 1 => STDOUT, 2 => STDERR ], $pipes);
    $proc_status = proc_get_status($process);
    $exit_code = proc_close($process);
    exit ($proc_status["running"] ? $exit_code : $proc_status["exitcode"]);
  }
}
