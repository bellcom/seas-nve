<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SolcelleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SolcelleRepository extends EntityRepository {
  public function findAll()
  {
    return $this->findBy(array(), array('KWp' => 'ASC'));
  }

  /**
   * Find a Solcelle by KWp.
   *
   * Return Solcelle with greatest KWp less than or equal to the specified KWp.
   *
   * @param float $KWp
   *   The KWp.
   *
   * @return Solcelle|NULL
   *   The Solcelle.
   */
  public function findByKWp($KWp) {
    // @FIXME: Use DQL for this.
    $items = $this->findBy(array(), array('KWp' => 'DESC'));
    foreach ($items as $solcelle) {
      if ($solcelle->getKWp() <= $KWp) {
        return $solcelle;
      }
    }

    return NULL;
  }

  /**
   * Check if entity can be removed (deleted). If not, return an error message.
   *
   * @return string|null
   */
  public function getRemoveErrorMessage(Solcelle $solcelle) {
    return null;
  }

  /**
   * Helper function to convert values to proper type.
   *
   * @param string $column
   * @param string $value
   *
   * @return string
   *
   * @throws
   */
  public function getTypedValue($column, $value) {
    switch ($column) {
      default;
        // Most of values are stringable.
        return (string) $value;
    }
  }

}
