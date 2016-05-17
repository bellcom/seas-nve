<?php

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class TiltagTypeExtension
 *
 * Twig extension to assist in polymorphic template rendering
 *
 * @package AppBundle\Twig\Extension
 */
class TransKeyExtension extends \Twig_Extension {

  private $translator;
  public function __construct(TranslatorInterface $translator) {
    $this->translator = $translator;
  }

  /**
   * {@inheritdoc}
   */
  public function getFilters()
  {
    return array(
      new Twig_SimpleFilter('get_trans', [$this, 'getTranslation'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('get_help', [$this, 'getHelpText'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('get_calculation', [$this, 'getCalculation'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('get_unit', [$this, 'getUnit'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('trans_field', [$this, 'getFieldTranslation'], ['is_safe' => ['all']]),
    );
  }

  public function getFieldTranslation($field, $entity) {
    $translated = $this->translator->trans($field);

    if ($field === $translated) {
      if (preg_match('/^AppBundle\\\\Entity\\\\(?<name>.+)/', get_class($entity), $matches)) {
        $entityName = str_replace('\\', '_', strtolower($matches['name']));
        $key = 'appbundle.' . $entityName . '.' . $field;
        $t = $this->translator->trans($key);
        if ($t != $key) {
          $translated = $t;
        }
      }
    }

    return $translated;
  }

  public function getTranslation($key) {
    $key = str_replace('_', '.', $key);
    $trans = $this->translator->trans($key);

    if($key === $trans) {
      $key = preg_replace('/\.[^.]*?tiltag\./', '.tiltag.', $key);
      $trans = $this->translator->trans($key);
    }

    // Reset ".1++." to ".0." for collections
    if($key === $trans) {
      $key = preg_replace('/\.\d+\./', '.0.', $key);
      $trans = $this->translator->trans($key);
    }

    return $trans;
  }

  public function getHelpText($key) {
    $key = str_replace('_', '.', $key);
    $key .= '.help';
    $trans = $this->translator->trans($key);

    if($key === $trans) {
      $key = preg_replace('/\.[^.]*?tiltag\./', '.tiltag.', $key);
      $trans = $this->translator->trans($key);
    }

    return ($key === $trans) ? '' : $trans;
  }

  public function getCalculation($key) {
    $key = str_replace('_', '.', $key);
    $key .= '.calculation';
    $trans = $this->translator->trans($key);
    return $trans !== $key ? $trans : null;
  }

  public function getUnit($key) {
    $key = str_replace('_', '.', $key);
    $key .= '.unit';
    $trans = $this->translator->trans($key);

    if($key === $trans) {
      $key = preg_replace('/\.[^.]*?tiltag\./', '.tiltag.', $key);
      $trans = $this->translator->trans($key);
    }

    return ($key === $trans) ? '' : $trans;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "trans_key_extension";
  }
}