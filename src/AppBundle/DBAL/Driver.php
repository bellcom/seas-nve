<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DBAL;

use Doctrine\DBAL\Driver\PDOMySql\Driver as BaseDriver;

/**
 * Class Driver
 * @package AppBundle\DBAL
 */
class Driver extends BaseDriver {
  /**
   * {@inheritdoc}
   */
  public function getDatabasePlatform() {
    return new Platform();
  }
}