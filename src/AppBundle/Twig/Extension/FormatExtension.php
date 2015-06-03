<?php

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class FormatExtension
 *
 * Twig extension to help formatting values (mostly numbers)
 *
 * @package AppBundle\Twig\Extension
 */
class FormatExtension extends \Twig_Extension {
  /**
   * {@inheritdoc}
   */
  public function getFilters()
  {
    return array(
      new Twig_SimpleFilter('format_integer', [$this, 'formatInteger'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_decimal', [$this, 'formatDecimal'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_percent', [$this, 'formatPercent'], ['is_safe' => ['all']]),
    );
  }

  public function formatInteger($number) {
    return $this->formatDecimal($number, 0);
  }

  public function formatDecimal($number, $numberOfDecimals = 2) {
    $formatter = $this->getNumberFormatter(null, \NumberFormatter::DECIMAL);
    $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $numberOfDecimals);
    $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $numberOfDecimals);
    return $formatter->format($number);
  }

  public function formatPercent($number, $numberOfDecimals = 0) {
    $formatter = $this->getNumberFormatter(null, \NumberFormatter::PERCENT);
    $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $numberOfDecimals);
    $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $numberOfDecimals);
    return $formatter->format($number);
  }

  private function getNumberFormatter($locale, $style) {
    static $formatter, $currentStyle;

    $locale = $locale !== null ? $locale : \Locale::getDefault();

    if ($formatter && $formatter->getLocale() === $locale && $currentStyle === $style) {
      // Return same instance of NumberFormatter if parameters are the same
      // to those in previous call
      return $formatter;
    }

    $formatter = \NumberFormatter::create($locale, $style);

    return $formatter;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return "format_extension";
  }
}