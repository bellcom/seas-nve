<?php

namespace AppBundle\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFilter;

/**
 * Class FormatExtension
 *
 * Twig extension to help formatting $values (mostly numbers)
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
      new Twig_SimpleFilter('format_json', [$this, 'formatToJSON'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_hundreds', [$this, 'formatToHundreds'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_tens', [$this, 'formatToTens'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_zeros', [$this, 'formatToZeros'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_integer', [$this, 'formatInteger'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_decimal', [$this, 'formatDecimal'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_amount', [$this, 'formatAmount'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_one_decimal', [$this, 'formatOneDecimal'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_percent', [$this, 'formatPercent'], ['is_safe' => ['all']]),
      new Twig_SimpleFilter('format_percent_nounit', [$this, 'formatPercentNoUnit'], ['is_safe' => ['all']]),
    );
  }

  public function formatToJSON($i) {
    return number_format($i, 2, ',', '');
  }

  public function formatToHundreds($i) {
    $rounded = $this->formatRound($i, -2);
    return number_format($rounded, 0, ',', '.');
  }

  public function formatToTens($i) {
    $rounded = $this->formatRound($i, -1);
    return number_format($rounded, 0, ',', '.');
  }

  public function formatToZeros($i) {
    $rounded = $this->formatRound($i, 0);
    return number_format($rounded, 0, ',', '.');
  }

  public function formatInteger($number) {
    return $this->formatDecimal($number, 0);
  }

  public function formatAmount($number, $numberOfDecimals = 0) {
    return $this->formatDecimal($number, $numberOfDecimals);
  }

  public function formatOneDecimal($number) {
    return $this->formatDecimal($number, 1);
  }

  public function formatDecimal($number, $numberOfDecimals = 2) {
    if ($number === NULL) {
      return '–';
    }
    // if number is smaller then what we can display with the given decimals
    if ($number < (1/pow(10, $numberOfDecimals) && $number > (-1/pow(10, $numberOfDecimals)))) {
      $number = 0;
    }
    $formatter = $this->getNumberFormatter(null, \NumberFormatter::DECIMAL);
    $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $numberOfDecimals);
    $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $numberOfDecimals);

    return $formatter->format($number);
  }

  public function formatPercent($number, $numberOfDecimals = 2) {
    if ($number === NULL) {
      return '–';
    }
    $formatter = $this->getNumberFormatter(null, \NumberFormatter::PERCENT);
    $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $numberOfDecimals);
    $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $numberOfDecimals);
    return $formatter->format($number);
  }

  public function formatPercentNoUnit($number, $numberOfDecimals = 2) {
    return $this->formatDecimal(100 * $number, $numberOfDecimals);
  }

  private function formatRound($value, $precision) {
    if ($precision < -4 || $precision > 15) {
      throw new \Exception($precision." - Must be and integer between -4 and 15");
    }

    $value = intval($value);

    if ($precision >= 0) {
      $rounded = round($value, $precision);
    }
    else {
      $precision = intval(pow(10, abs($precision)));
      $value = $value >= 0 ? $value + (5 * $precision / 10) : $value - (5 * $precision / 10);
      $rounded = round($value - ($value % $precision), 0);
    }

    // +0 to avoid "-0" output
    return $rounded + 0;
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