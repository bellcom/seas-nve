<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\SpecialTiltag;

/**
 * Class TiltagTypeExtension
 *
 * @TODO: Missing description.
 *
 * @package AppBundle\Twig\Extension
 */
class TiltagTypeExtension extends \Twig_Extension {
  /**
   * @TODO: Missing description.
   *
   * @return array
   *   @TODO: Missing description.
   */
  public function getFunctions() {
    return array(
      'tiltag_type' => new \Twig_Function_Method($this, 'getTiltagType', array('is_safe' => array('html'))),
      'is_missing_tiltag_type' => new \Twig_Function_Method($this, 'isMissingTiltagType', array('is_safe' => array('html')))
    );
  }

  /**
   * @TODO: Missing description.
   *
   * @param $object
   *   @TODO: Missing description.
   * @return string
   *   @TODO: Missing description.
   */
  public function getTiltagType($object) {
    if ($object instanceof SpecialTiltag) {
      return "specialtiltag";
    }
    else if ($object instanceof PumpeTiltag) {
      return "pumpetiltag";
    }
    else if ($object instanceof Tiltag) {
      return "tiltag";
    }
    else {
      throw new \InvalidArgumentException('Cannot get type of non-Tiltag objects');
    }
  }

  /**
   * @TODO: Missing description.
   *
   * @param $tiltag
   *   @TODO: Missing description.
   * @param $type
   *   @TODO: Missing description.
   * @return bool
   *   @TODO: Missing description.
   */
  public function isMissingTiltagType($tiltag, $type) {
    foreach ($tiltag as $t) {
      if ($this->getTiltagType($t) === $type) {
        return FALSE;
      }
      else {
        return TRUE;
      }
    }

    // Default: empty array.
    return TRUE;
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return "tiltag_type_extension";
  }
}