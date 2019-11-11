<?php

namespace AppBundle\Calculation;

use AppBundle\Entity\VirksomhedRapport;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class SummarizedRapportData {

    public function __construct($rapport) {
        $this->rapport = $rapport;
        foreach ($this->rapport->getSummarizedRapportValues() as $_key => $_value) {
            $this->$_key = $_value;
        }
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /** @var VirksomhedRapport */
    protected $rapport;

    /** @var PropertyAccessor $accessor */
    protected $accessor;

    public function expr($propertyName)
    {
        return $this->rapport->getSummarized($propertyName) ? $this->rapport->calculateSummarized($propertyName, TRUE) : '';
    }
}
