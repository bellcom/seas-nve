<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * ReportTextRepository
 *
 */
class ReportTextRepository extends EntityRepository {

    /**
     * Get default text by section type and fields name.
     *
     * @param string $sectionType
     *   Section type.
     * @param string $field
     *   Field name.
     *
     * @return ReportText|null
     */
    public function getDefaultText($sectionType, $field) {
        // Default text type is stored as rapportSektionType_fieldName.
        $defaultTextType = $sectionType . '_' . $field;

        /** @var ReportText $entity */
        $entity = $this->findOneBy(['type' => $defaultTextType, 'standard' => TRUE]);

        return $entity;
    }

}
