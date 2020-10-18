<?php

namespace AppBundle\Entity\RapportSektioner;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;


/**
 * OpsummeringRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class OpsummeringRapportSektion extends RapportSektion {
}

