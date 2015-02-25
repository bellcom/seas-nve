<?php

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\SpecialTiltag;

class TiltagTypeExtension extends \Twig_Extension
{
  public function getFunctions()
  {
    return array(
      'tiltag_type' => new \Twig_Function_Method($this, 'getTiltagType', array('is_safe' => array('html'))),
      'is_missing_tiltag_type' => new \Twig_Function_Method($this, 'isMissingTiltagType', array('is_safe' => array('html')))
    );
  }

  public function getTiltagType($object)
  {
    if ($object instanceof SpecialTiltag) {
      return "specialtiltag";
    } else if ($object instanceof PumpeTiltag) {
      return "pumpetiltag";
    } else if ($object instanceof Tiltag) {
      return "tiltag";
    }
    throw new \InvalidArgumentException('Cannot get type of non-Tiltag objects');
  }

  public function isMissingTiltagType($tiltag, $type) {

    foreach($tiltag as $t) {
      if($this->getTiltagType($t) === $type) {
        return false;
      } else {
        return true;
      }
    }

    //Default / empty array
    return true;
  }

  public function getName()
  {
    return "tiltag_type_extension";
  }
}