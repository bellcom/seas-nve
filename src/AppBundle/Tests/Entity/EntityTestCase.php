<?php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class EntityTestCase extends KernelTestCase {
  /**
   * Set properties on an entity.
   *
   * @param object $entity
   *   The entity.
   * @param array $properties
   *   The properties.
   *
   * @return object
   *   The entity
   */
  protected function loadEntity($entity, array $properties) {
    if ($properties) {
      foreach ($properties as $name => $value) {
        if ($name == 'id') {
          $reflectionClass = new \ReflectionClass($entity);
          $reflectionProperty = $reflectionClass->getProperty('id');
          $reflectionProperty->setAccessible(true);
          $reflectionProperty->setValue($entity, $value);
        } else {
          $propertyName = $this->getPropertyName($name);
          $entity->{'set'.$propertyName}($value);
        }
      }

      // Call the protected compute method (!) (cf. https://sebastian-bergmann.de/archives/881-Testing-Your-Privates.html)
      try {
        $compute = new \ReflectionMethod($entity, 'compute');
        if ($compute) {
          $compute->setAccessible(true);
          $compute->invoke($entity);
        }
      } catch (\ReflectionException $ex) {}
    }

    return $entity;
  }

  /**
   * Assert that properties on an entity equals expected values.
   *
   * @param object $entity
   *   The entity.
   * @param array $properties
   *   The properties.
   */
  protected function assertProperties($entity, array $properties) {
    if ($properties) {
      foreach ($properties as $name => $value) {
        $propertyName = $this->getPropertyName($name);
        $this->assertEquals($value, $entity->{'get'.$propertyName}(), __METHOD__ . ' '. $propertyName);
      }
    }
  }

  /**
   * Convert snake_case to PascalCase.
   *
   * @param string $name
   *   The name.
   *
   * @return string
   *   The key converted to PascalCase
   */
  private function getPropertyName($name) {
    return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) {
      return ('.' === $match[1] ? '_' : '') . strtoupper($match[2]);
    }, $name);
  }

}
