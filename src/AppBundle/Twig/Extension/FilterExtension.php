<?php

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class TiltagTypeExtension
 *
 * Twig extension to assist in polymorphic template rendering
 *
 * @package AppBundle\Twig\Extension
 */
class FilterExtension extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getFilters()
  {
    return array(
      new Twig_SimpleFilter('b2icon', [$this, 'booleanToIconFilter'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('b2class', [$this, 'booleanToClassFilter'], ['is_safe' => ['all']]),
    );
  }

  public function booleanToIconFilter($boolean) {
    if($boolean === NULL) {
      return '';
    } else {
      return $boolean ? '<span class="fa fa-check"></span>' : '';
    }
  }

  public function booleanToClassFilter($boolean) {
    if($boolean === NULL) {
      return '';
    } else {
      return $boolean ? 'selected' : 'not-selected';
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "filter_extension";
  }
}