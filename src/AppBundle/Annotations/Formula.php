<?php
namespace AppBundle\Annotations;

/** @Annotation */
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

    public function __toString()
    {
        return $this->formula;
    }
}
