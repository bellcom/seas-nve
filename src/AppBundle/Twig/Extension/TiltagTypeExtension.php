<?php

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\SpecialTiltag;


/**
 * Class TiltagTypeExtension
 *
 * Twig extension to assist in polymorphic template rendering
 *
 * @package AppBundle\Twig\Extension
 */
class TiltagTypeExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getFunctions() {
    return array(
      'tiltag_type' => new \Twig_Function_Method($this, 'getTiltagType', ['is_safe'=>['html']]),
      'tiltag_route' => new \Twig_Function_Method($this, 'getTiltagRouteName', array('is_safe' => array('html'))),
      'is_missing_tiltag_type' => new \Twig_Function_Method($this, 'isMissingTiltagType', array('is_safe' => array('html')))
    );
  }

  /**
   * Get a string representation of the type of 'tiltag'
   *
   * @param $object
   *   The instance to get the type of. Must be Tiltag or descendant of Tiltag
   * @return string
   *   String representation of the type
   */
  public function getTiltagType(Tiltag $object) {
    if ($object instanceof SpecialTiltag) {
      return "specialtiltag";
    }
    else if ($object instanceof PumpeTiltag) {
      return "pumpetiltag";
    }
    else {
      throw new \InvalidArgumentException('Cannot get type of non-Tiltag objects');
    }
  }


  /**
   * Get the route name for the type of Tiltag / Action
   *
   * @param $object
   *   The instance to get the type of. Must be Tiltag or descendant of Tiltag
   * @param $action
   *   String representation of the action
   * @return string
   *   The name of the route
   */
  public function getTiltagRouteName(Tiltag $object, $action) {
    return $this->getTiltagType($object).'_'.$action;
  }

  /**
   * @TODO: Missing description.
   *
   * @param $tiltag
   *   Array of Tiltag to check for the type in. Must be Tiltag or descendant of Tiltag
   * @param $type
   *   String representation of the type to check for
   * @return bool
   *   @TODO: Missing description.
   */
  public function isMissingTiltagType($tiltag, $type) {
    foreach ($tiltag as $t) {
      if ($this->getTiltagType($t) === $type) {
        return FALSE;
      }
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "tiltag_type_extension";
  }
}