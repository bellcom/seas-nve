<?php

namespace AppBundle\Calculation;

abstract class Calculation {
  private static $allowedDeviance = 0.0001;

  /**
   * Check if two numeric values are equals within some deviance.
   *
   * @param float $a
   *   A value.
   * @param float $b
   *   Another value.
   * @param float $allowedDeviance (optional)
   *   The allowed deviance (a number between 0 and 1).
   *
   * @return boolean
   *   True iff the values are equal within the allowed deviance.
   */
  public static function areEqual($a, $b, $allowedDeviance = NULL) {
    $delta = abs(min($a, $b) * ($allowedDeviance === NULL ? self::$allowedDeviance : $allowedDeviance));
    if (abs($a - $b) > $delta) {
      return false;
    }
    return true;
  }

}