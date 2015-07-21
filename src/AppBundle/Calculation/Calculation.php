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

  /**
   * Decide if any calculated values (numeric only) in entity will have different values if re-calculated.
   *
   * @FIXME:
   *
   * @param object $entity.
   *   The entity.
   *
   * @return array of string
   *   Whether any numeric value will if re-calculating values.
   */
  public function getChanges($entity) {
    $old = $entity;
    $new = $this->calculate(clone $old);

    $getters = array_filter(get_class_methods($entity), function($method) { return strpos($method, 'get') === 0; });
    $changes = array();
    foreach ($getters as $getter) {
      $oldValue = $old->{$getter}();
      $newValue = $new->{$getter}();
      // Compare numeric values with a fixed scale
      if (is_numeric($oldValue) && is_numeric($newValue) && !self::areEqual($oldValue, $newValue)) {
        $changes[] = array(
          'property' => lcfirst(preg_replace('/^get/', '', $getter)),
          'oldValue' => $oldValue,
          'newValue' => $newValue,
        );
      }
    }

    return $changes;
  }

  /**
   * Calculate Net Present Value
   *
   * @param float $rate
   *   The rate.
   *
   * @param array $values
   *   The values. Indexes should be years (from 1).
   *
   * @return float
   *   The npv.
   */
  public static function npv($rate, array $values) {
    $npv = 0;

    // @see http://stackoverflow.com/questions/2027460/how-to-calculate-npv
    foreach ($values as $year => $value) {
      $npv += $value / pow(1 + $rate, $year);
    }

    return $npv;
  }

  public static function divide($numerator, $denominator) {
    return $denominator == 0 ? 0 : ($numerator / $denominator);
  }

  // @see https://en.wikipedia.org/wiki/Mortgage_calculator#Monthly_payment_formula
  public static function pmt($r, $N, $P) {
    return -self::divide($r * $P, 1 - pow(1 + $r, -$N));
  }

}