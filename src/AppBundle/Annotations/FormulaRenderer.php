<?php

namespace AppBundle\Annotations;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class FormulaRenderer
 * @package AppBundle\Annotations
 */
class FormulaRenderer {

    /** @var string $pattern */
    private $pattern = '/\\$this->(\\w*)/im';

    /** @var array $annotations */
    private $annotations = array();

    /** @var object $entity */
    private $entity;

    public function __construct($entity) {
        $this->entity = $entity;
        $class = get_class($entity);
        $f = new \ReflectionClass($class);
        $annotationReader = new AnnotationReader();
        foreach ($f->getMethods() as $method) {
            if (strpos($method->name, 'calculate') === FALSE) {
                continue;
            }
            $property = lcfirst(str_replace('calculate', '', $method->name));
            if (property_exists($class, $property)) {
                $reflectionMethod = new \ReflectionMethod($class, $method->name);
                $annotations = $annotationReader->getMethodAnnotations($reflectionMethod);
                if (empty($annotations)) {
                    continue;
                }

                foreach ($annotations as  $annotation) {
                    if ($annotation instanceof Formula) {
                        $this->annotations[$property] = $annotation;
                    }
                }
            }
        }
    }

    public function __get($propertyName) {
        if (!empty($this->annotations[$propertyName])) {
            $string = $this->annotations[$propertyName];
            preg_match_all($this->pattern, $this->annotations[$propertyName], $matches);
            foreach ($matches[1] as $key => $match) {
                $args = array();
                $matched_str = $matches[0][$key];
                // Resolving property getter method.
                if (strpos($match, 'get') !== FALSE && method_exists($this->entity, $match)) {
                    $method = $match;
                    $matched_str .= '()';
                }
                // Resolving calculation values through getCalculated() method.
                elseif (strpos($match, 'calculate') !== FALSE && method_exists($this->entity, 'getCalculated')) {
                    $method = 'getCalculated';
                    $args[] = $match;
                    $matched_str .= '()';
                }
                // Resolving property through getter method.
                elseif (method_exists($this->entity, 'get' . ucfirst($match))) {
                    $method = 'get' . ucfirst($match);
                }
                else {
                    continue;
                }
                $value = call_user_func_array(array($this->entity, $method), $args);
                if ((float) $value == $value) {
                    $value = round($value, 2);
                }
                $string = str_replace($matched_str, $value, $string);
            }
            // Replace dots with comas to get ability copy paste and calculate.
            return str_replace('.', ',', $string);
        }

        return NULL;
    }

    public function __isset($propertyName) {
        return isset($this->annotations[$propertyName]);
    }

    public function replaceCallback($match) {
        $i = 1;
    }

}
