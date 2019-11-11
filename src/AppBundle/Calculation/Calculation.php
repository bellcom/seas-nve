<?php

namespace AppBundle\Calculation;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class Calculation {
  private static $allowedDeviance = 0.0001;

  protected $container = null;

  public function __construct(Container $container) {
    $this->container = $container;
  }

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
   * Format a number.
   */
  protected static function formatNumber($value) {
    $decimals = abs(log10(self::$allowedDeviance));
    return number_format($value, $decimals);
  }

  /**
   * Format all numbers in array structure.
   */
  private static function formatNumbers(array &$array) {
    array_walk_recursive($array, function(&$value) {
      if (is_numeric($value)) {
        $value = self::formatNumber($value);
      }
    });
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
    $changes = array();
    $calculatedFields = $this->getCalculatedFields($entity);

    if ($calculatedFields) {
      $old = $entity;
      $new = $this->calculate(clone $old);

      foreach ($calculatedFields as $field) {
        try {
          $name = $field['fieldName'];
          $type = $field['type'];
          $getter = 'get' . $name;
          if (method_exists($old, $getter)) {
            $oldValue = $old->{$getter}();
            $newValue = $new->{$getter}();

            if (is_array($oldValue) && is_array($newValue)) {
              // Format numbers in arrays to make comparison make sense.
              self::formatNumbers($oldValue);
              self::formatNumbers($newValue);
            }

            $isChanged = $oldValue != $newValue;
            switch ($type) {
              case 'float':
                // Compare numeric values with a fixed scale
                $isChanged = !self::areEqual($oldValue, $newValue);
                break;
            }

            if ($isChanged) {
              $changes[] = array(
                'property' => $name,
                'type' => $type,
                'oldValue' => $oldValue,
                'newValue' => $newValue,
              );
            }
          }
        } catch (\Exception $ex) {}
      }
    }

    return $changes;
  }

  /**
   * Get calculated fields on an entity.
   *
   * @param Entity $entity
   *   The entity.
   *
   * @return Array
   *   List of calculated fields.
   */
  protected function getCalculatedFields($entity) {
    $reflectionClass = new \ReflectionClass($entity);
    $properties = $reflectionClass->getProperties();

    $calculatedFieldNames = array_map(function($property) {
      return $property->getName();
    }, array_filter($properties, function($property) {
      return strpos($property->getDocComment(), '@Calculated') !== FALSE;
    }));

    $em = $this->container->get('doctrine')->getManager();
    $className = get_class($entity);
    $metadata = $em->getClassMetadata($className);

    return array_filter($metadata->fieldMappings, function($field) use ($calculatedFieldNames) {
      return in_array($field['fieldName'], $calculatedFieldNames);
    });
  }

  public static function getCalculationWarnings($entity, array $properties, $prefix = '', $subEntities = null) {
    $accessor = PropertyAccess::createPropertyAccessor();
    $errors = array();

    if (!empty($properties)) {
      $propertyErrors = array_filter($properties, function ($property) use ($entity, $accessor) {
        $value = $accessor->isReadable($entity, $property) ? $accessor->getValue($entity, $property) : null;
        return $value === null;
      });

      if ($prefix) {
        $propertyErrors = array_map(function($error) use ($prefix) {
          return 'appbundle.' . $prefix . '.' . $error;
        }, $propertyErrors);
      }
    }
    if (!empty($propertyErrors)) {
      $errors['errors'] = $propertyErrors;
    }

    if (!empty($subEntities)) {
      foreach ($subEntities as $e) {
        if($e->getCalculationWarnings()) {
          $errors[$prefix][] = $e->getIndexNumber();
        }
      }
    }

    return $errors;
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
   * @return float|array
   *   The npv.
   */
  public static function npv($rate, array $values, $array = FALSE) {
    $npv_result = array();

    // @see http://stackoverflow.com/questions/2027460/how-to-calculate-npv
    foreach ($values as $year => $value) {
      $npv_result[] = $value / pow(1 + $rate, $year);
    }

    if ($array) {
      foreach ($npv_result as &$value) {
        $value = round($value, 2);
      }
      return $npv_result;
    }

    return array_sum($npv_result);
  }

  public static function divide($numerator, $denominator) {
    return $denominator == 0 ? 0 : ($numerator / $denominator);
  }

  // @see https://en.wikipedia.org/wiki/Mortgage_calculator#Monthly_payment_formula
  public static function pmt($r, $N, $P) {
    return -self::divide($r * $P, 1 - pow(1 + $r, -$N));
  }

  public static function fordelbesparelse($BesparKwh, $kilde, $type) {
    if ($kilde) {
      switch ($type) {
        case 'EL':
        case 'VARME':
        case 'PRIORITEREL':
        case 'PRIORITERVARME':
          /* Konverteringer bruges ikke – endnu …
             If Worksheets("2.Forsyning").Range("al" & y) <> "" Then 'der er beregnet konvertering
             t = Worksheets("2.Forsyning").Range("al" & y).Value 'række for konvertering indtastes

             If Worksheets("2.Forsyning").Range("a" & t) <> "" Then 'konverteringen er tilvalgt
             If typen = "EL" Or typen = "VARME" Then
             If Worksheets("2.Forsyning").Range("am" & t) = 1 Then 'konvertering prioriteres forud for øvrige tiltag
             y = t 'denne funktion bypasses hvis de er er tale om KONVERTERINGVARME eller KONVERTERINGEL, hvor det eksisterende værks værdier skal anvendes.
             'MsgBox ("y er " & y)
             End If

             ElseIf typen = "PRIORITEREL" Then
             y = t 'prioriterel og varme er altid efter nye forsyningskildes effektivitet, uanset om prioritering er 1 eller 2
             typen = "EL"
             ElseIf typen = "PRIORITERVARME" Then
             y = t
             typen = "VARME"
             'MsgBox ("prioritering virker")
             End If
             End If
             End If
          */
          break;

        case 'KONVERTERINGVARME':
          $type = 'VARME';
          break;

        case 'KONVERTERINGEL':
          $type = 'EL';
          break;

      }

      if ($type == 'EL') {
        $BesparKwh *= $kilde->getSamletEleffektivitet();
      }
      elseif ($type == 'VARME') {
        $BesparKwh *= $kilde->getSamletVarmeeffektivitet();
      }
    }

    if ($type == 'EL' || $type == 'VARME') {
      return $BesparKwh;
    }

    return 0;

    /*
Public Function FordelBesparelse(BesparKwh As Single, Kilde As String, typen As String)

    Dim lastRow As Integer
    Dim y As Integer
    Dim t As Integer

    With Worksheets("2.Forsyning")
        lastRow = Worksheets("2.Forsyning").Range("a3").Value 'sidste række i øverste tabel
    End With

    For y = 14 To lastRow

        If Worksheets("2.Forsyning").Range("a" & y) = Kilde Then
            If typen = "EL" Or typen = "VARME" Or typen = "PRIORITEREL" Or typen = "PRIORITERVARME" Then 'tjekker at der er tale om alm. el og varme og ikke "konverteringvarme" hvor det gamle forsyningsværks værdier skal bruges
                If Worksheets("2.Forsyning").Range("al" & y) <> "" Then 'der er beregnet konvertering
                    t = Worksheets("2.Forsyning").Range("al" & y).Value 'række for konvertering indtastes

                    If Worksheets("2.Forsyning").Range("a" & t) <> "" Then 'konverteringen er tilvalgt
                        If typen = "EL" Or typen = "VARME" Then
                            If Worksheets("2.Forsyning").Range("am" & t) = 1 Then 'konvertering prioriteres forud for øvrige tiltag
                                y = t 'denne funktion bypasses hvis de er er tale om KONVERTERINGVARME eller KONVERTERINGEL, hvor det eksisterende værks værdier skal anvendes.
                                'MsgBox ("y er " & y)
                            End If

                        ElseIf typen = "PRIORITEREL" Then
                        y = t 'prioriterel og varme er altid efter nye forsyningskildes effektivitet, uanset om prioritering er 1 eller 2
                        typen = "EL"
                        ElseIf typen = "PRIORITERVARME" Then
                        y = t
                        typen = "VARME"
                        'MsgBox ("prioritering virker")
                        End If
                    End If
                End If

            ElseIf typen = "KONVERTERINGVARME" Then 'dvs. regner altid med gamle værks effektivitet
                typen = "VARME"
            ElseIf typen = "KONVERTERINGEL" Then 'dvs. regner altid med gamle værks effektivitet
                typen = "EL"
            End If

            If typen = "EL" Then
                 BesparKwh = BesparKwh * Worksheets("2.Forsyning").Range("ak" & y)
            End If

            If typen = "VARME" Then
                BesparKwh = BesparKwh * Worksheets("2.Forsyning").Range("aj" & y)
            End If

            y = lastRow 'såfremt der forsyningskilden er fundet, skal efterfølgende rækker ikke kontrolleres
        End If

    Next y

    If typen = "VARME" Then
        FordelBesparelse = BesparKwh
    End If

    If typen = "EL" Then
        FordelBesparelse = BesparKwh
    End If

End Function
*/
  }

}
