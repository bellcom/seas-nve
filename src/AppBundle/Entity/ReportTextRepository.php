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
     * @param string $rapportType
     *   Rapport type.
     * @param string $field
     *   Field name.
     *
     * @return ReportText|null
     */
    public function getDefaultText($sectionType, $rapportType, $field) {
        // Default text type is stored as rapportSektionType_fieldName.
        $defaultTextType = $sectionType . '_' . $field;

        $criteria = ['type' => $defaultTextType];
        switch($rapportType) {
            case VirksomhedRapport::RAPPORT_ENERGISYN:
                $criteria['standardVirkEnergisyn'] = TRUE;
                break;

            case VirksomhedRapport::RAPPORT_SCREENING:
                $criteria['standardVirkScreening'] = TRUE;
                break;

            case VirksomhedRapport::RAPPORT_DETAILARK:
                $criteria['standardVirkDetailark'] = TRUE;
                break;

            default:
                return NULL;
        }
        /** @var ReportText $entity */
        $entity = $this->findOneBy($criteria);

        return $entity;
    }

}
