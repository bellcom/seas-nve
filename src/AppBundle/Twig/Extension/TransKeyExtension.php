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

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "trans_key_extension";
  }
}