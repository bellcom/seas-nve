<?php
namespace AppBundle\Annotations;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * Class Formula
 * @Annotation
 * @package AppBundle\Annotations
 */
class Formula
{
    /**
     * @var string $formula
     */
    protected $formula;

    /**
     * Calculated constructor.
     * @param $formula
     */
    public function __construct($formula)
    {
        $this->formula = $formula['value'];
    }

    /**
     * Returns formula from annotation.
     *
     * @return mixed|string
     */
    public function __toString()
    {
        return $this->formula;
    }

    static function parseAnnotation($entity) {
        $formulas = array();
        $class = get_class($entity);
        $f = new \ReflectionClass($class);
        $annotationReader = new AnnotationReader();
        foreach ($f->getProperties() as $property) {
            $reflectionMethod = new \ReflectionProperty($class, $property->name);
            $annotations = $annotationReader->getPropertyAnnotations($reflectionMethod);
            if (empty($annotations)) {
                continue;
            }

            foreach ($annotations as $annotation) {
                if ($annotation instanceof Formula) {
                    $formulas[$property->name] = $annotation;
                }
            }
        }

        foreach ($f->getMethods() as $method) {
            if (strpos($method->name, 'calculate') === FALSE) {
                continue;
            }
            $property = lcfirst(str_replace('calculate', '', $method->name));
            if (property_exists($class, $property) && !isset($formulas[$property])) {
                $reflectionMethod = new \ReflectionMethod($class, $method->name);
                $annotations = $annotationReader->getMethodAnnotations($reflectionMethod);
                if (empty($annotations)) {
                    continue;
                }

                foreach ($annotations as $annotation) {
                    if ($annotation instanceof Formula) {
                        $formulas[$property] = $annotation;
                    }
                }
            }
        }

        return $formulas;
    }
}
