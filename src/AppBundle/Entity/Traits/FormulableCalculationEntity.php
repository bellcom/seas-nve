<?php

namespace AppBundle\Entity\Traits;

use AppBundle\Annotations\Formula;

/**
 * FormulableCalculationEntity class.
 */
trait FormulableCalculationEntity {

  /**
   * Array with formulas from annotation.
   *
   * @var array
   */
  protected $fx;

  private function initFormulableCalculation() {
    $this->fx = Formula::parseAnnotation($this);
  }

  /**
   * Calculate function that parse expressions from annotation and calculate it.
   *
   * Functions are allowed for expressions ONLY without arguments.
   *
   * Function works only with default values.
   * If value already calculated it will be cached.
   *
   * @param string $formulaKey
   * @param bool $expression
   * @return mixed|null
   * @throws
   */
  public function calculateByFormula($formulaKey, $expression = FALSE) {
    $string = NULL;
    if (isset($this->fx[$formulaKey])) {
      $string = $this->fx[$formulaKey];
    }
    elseif (isset($this->fx['calculate' . ucfirst( $formulaKey)])) {
      $string = $this->fx['calculate' . ucfirst( $formulaKey)];
    }
    elseif (isset($this->fx['get' . ucfirst( $formulaKey)])) {
      $string = $this->fx['get' . ucfirst( $formulaKey)];
    }
    else {
      return NULL;
    }

    // Matching properties and methods.
    preg_match_all('/\\$this->(\\w*)/im', $string, $matches);
    foreach ($matches[1] as $key => $match) {
      $value = NULL;
      $args = array();
      $matched_str = $matches[0][$key];
      // Resolving getter and calculate methods.
      // Resolving calculation values through getCalculated() method.
      if ((strpos($match, 'get') !== FALSE || strpos($match, 'calculate') !== FALSE)
        && method_exists($this, $match)) {
        $method = $match;
        $matched_str .= '()';
      }
      // Resolving property through getter method.
      elseif (method_exists($this, 'get' . ucfirst($match))) {
        $method = 'get' . ucfirst($match);
      }
      // Resolving by common calculateExpression function.
      elseif (method_exists($this, 'calculateExpression')) {
        $method = 'calculateExpression';
        $matched_str .= '()';
        $args[] = $formulaKey;
      }
      else {
        continue;
      }

      $methodInfo = new \ReflectionMethod($this, $method);

      // Prefill default arguments.
      foreach ($methodInfo->getParameters() as $p) {
        if (!$p->isDefaultValueAvailable()) {
          continue;
        }
        $args[] = $p->getDefaultValue();
      }

      // Don't call method if it requires parameter. Functions call works only without values.
      if (count($methodInfo->getParameters()) != count($args)) {
        return NULL;
      }
      $value = call_user_func_array(array($this, $method), $args);
      // Converting values to float. Expressions should not be converted.
      if ((is_numeric($value) && $value != '') || $value === NULL) {
        $value = round($value, 2);
      }
      $string = str_replace($matched_str, $value, $string);
    }

    return $expression ? $string : $this->proceedMathExpression($string);
  }

  /**
   * Calculates simple math expressions.
   *
   * @param $expression
   * @return null
   */
  private function proceedMathExpression($expression) {
    $result = NULL;
    // Execute only numbers in math expression.
    eval('$result = ' . preg_replace('/[^0-9\+\-\*\/\(\)\.]/', '', $expression) . ';');
    return $result;
  }

  /**
   * Calculates property values and returns expressions.
   *
   * @param $propertyName
   * @return string|null
   */
  public function expr($propertyName) {
    $expression = $this->calculateByFormula($propertyName, TRUE);
    return str_replace('.', ',', $expression);
  }

  /**
   * Generates SUM() expression from values in array.
   *
   * @param $array_values
   * @return string
   */
  public function sumExpr($array_values) {
    return $this->mathArrayExpr($array_values, ' + ', 'SUM(', ')');
  }

  /**
   * Generates math iterator expression from values in array.
   */
  public function mathArrayExpr($array_values, $separator = ' ; ', $prefix = '', $suffix = '') {
    foreach ($array_values as &$value) {
      if ($value === NULL) {
        $value = 0;
      }
      else {
        $value = round($value, 2);
      }
    }
    return $prefix . (empty($array_values) ? '0' : implode($separator, $array_values)) . $suffix;
  }

}
