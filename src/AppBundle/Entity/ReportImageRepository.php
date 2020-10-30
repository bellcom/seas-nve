<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ReportImageRepository
 *
 */
class ReportImageRepository extends EntityRepository {

    /**
     * Get default image by section type.
     *
     * @param string $sectionType
     *   Section type.
     *
     * @return ReportImage|null
     */
    public function getDefaultImage($sectionType) {
        /** @var ReportImage $entity */
        $entity = $this->findOneBy(['type' => $sectionType, 'standard' => TRUE]);
        return $entity;
    }

}
