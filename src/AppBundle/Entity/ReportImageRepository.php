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
    public function getDefaultImage($sectionType, $rapportType) {
      $criteria = ['type' => $sectionType];
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
        /** @var ReportImage $entity */
        $entity = $this->findOneBy($criteria);
        return $entity;
    }

}
