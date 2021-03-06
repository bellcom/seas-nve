<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * KlimaskaermRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KlimaskaermRepository extends EntityRepository {
  public function findByType($type) {
    $query = $this->_em->createQuery('SELECT k FROM AppBundle:Klimaskaerm k WHERE k.type = :type')
           ->setParameter('type', $type);
    return $query->getResult();
  }

  /**
   * Check if entity can be removed (deleted). If not, return an error message.
   *
   * @return string|null
   */
  public function getRemoveErrorMessage(Klimaskaerm $klimaskaerm) {
    $query = $this->_em->createQuery('SELECT d FROM AppBundle:NyKlimaskaermTiltagDetail d WHERE d.klimaskaerm = :klimaskaerm');
    $query->setParameter('klimaskaerm', $klimaskaerm);
    $result = $query->getResult();

    if ($result) {
      return 'klimaskaerm.error.in_use';
    }

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
