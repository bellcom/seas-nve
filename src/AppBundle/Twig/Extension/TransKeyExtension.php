<?php

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;
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
    );
  }

  public function getTranslation($key) {
    $key = str_replace('_', '.', $key);
    $trans = $this->translator->trans($key);

    if($key === $trans) {
      $key = preg_replace('/\.[^.]*?tiltag\./', '.tiltag.', $key);
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

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "trans_key_extension";
  }
}