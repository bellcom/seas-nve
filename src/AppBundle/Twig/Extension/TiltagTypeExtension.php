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
      'tiltag_type' => new \Twig_Function_Method($this, 'getTiltagType', array('is_safe' => array('html')))
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

  public function getName()
  {
    return "tiltag_type_extension";
  }
}