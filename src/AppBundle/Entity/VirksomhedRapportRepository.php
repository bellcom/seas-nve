<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\BygningStatusType;
use AppBundle\Entity\RapportSektioner\ForsideRapportSektion;
use AppBundle\Entity\RapportSektioner\RapportSektion;
use AppBundle\Entity\RapportSektioner\RapportSektionRepository;
use AppBundle\Entity\RapportSektioner\TiltagRapportSektion;
use AppBundle\Form\Type\RapportSektion\ForsideRapportSektionType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Query;
use Gedmo\Exception\UploadableInvalidMimeTypeException;

/**
 * VirksomhedRapportRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VirksomhedRapportRepository extends BaseRepository {

    /**
     * Search all Virksomhed Rapport by request params.
     *
     * @param bool $returnQuery
     * @return array|\Doctrine\ORM\Query
     */
    public function search($search) {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('vr', 'v')
            ->from('AppBundle:VirksomhedRapport', 'vr')
            ->leftJoin('vr.virksomhed', 'v')
        ;

        if (!empty($search['elena'])) {
            $qb->andWhere('vr.elena = :elena')
                ->setParameter('elena', $search['elena']);
        }

        if ($search['ava'] !== NULL) {
            $qb->andWhere('vr.ava = :ava')
                ->setParameter('ava', $search['ava']);
        }

        if (!empty($search['datering'])) {
            $qb->andWhere('vr.datering LIKE :datering')
                ->setParameter('datering', $search['datering'] . '%');
        }

        if (!empty($search['name'])) {
            $qb->andWhere('v.name LIKE :name')
                ->setParameter('name', '%' . $search['name'] . '%');
        }

        if (!empty($search['address'])) {
            $qb->andWhere('v.address LIKE :address')
                ->setParameter('address', '%' . $search['address'] . '%');
        }

        if (!empty($search['version'])) {
            $qb->andWhere('vr.version = :version')
                ->setParameter('version', $search['version']);
        }

        $qb->addOrderBy('v.id', 'desc');

        return $qb->getQuery();
    }

    public function getOverviewRapportSektionerSorted(VirksomhedRapport $entity) {
        return $this->getRapportSektionerSorted($entity, VirksomhedRapport::RAPPORT_ENERGISYN);
    }

    public function getScreeningRapportSektionerSorted(VirksomhedRapport $entity) {
        return $this->getRapportSektionerSorted($entity, VirksomhedRapport::RAPPORT_SCREENING);
    }

    /**
     * Gets Rapport sektions in sorted order for specific rapport type. Creates missing sections with default values.
     *
     * @param VirksomhedRapport $entity
     * @return array
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
     */
    public function getRapportSektionerSorted(VirksomhedRapport $entity, $rapportType) {
        $sectionsSorted = [];
        foreach ($entity->getRapportSektionerStruktur($rapportType) as $sectionType) {
            $className = RapportSektion::getRapportSektionClassByType($sectionType, TRUE);
            // Check if required amount sections are present.
            $checkSectionMethod = 'checkRapportSektion';
            if (method_exists($this, "check" . $className)) {
                $checkSectionMethod = "check" . $className;
            }
            $sections = $this->$checkSectionMethod($entity, $rapportType, $sectionType);
            foreach ($sections as $section) {
                $section->init($this->_em);
                $sectionsSorted[] = clone $section;
            }
        }
        return $sectionsSorted;
    }

    protected function checkRapportSektion(VirksomhedRapport $entity, $rapportType, $sectionType) {
        $sections = $entity->getRapportSektioner($rapportType);
        $existing = $sections->filter(function($section) use ($sectionType) {
            return get_class($section) == RapportSektion::getRapportSektionClassByType($sectionType);
        });

        if ($existing->count() >= 1) {
            return $existing->toArray();
        }

        // Creating missing sections.
        $sections = [];
        for ($i = 0; $i < 1; $i++) {
            /** @var RapportSektionRepository $sektionerRepository */
            $sektionRepository = $this->_em->getRepository('AppBundle:RapportSektioner\RapportSektion');
            /** @var RapportSektion $newSection */
            $newSection = $sektionRepository->create($sectionType, array('rapport_type' => $rapportType));
            $entity->addRapportSektion($newSection, $rapportType);

            $this->_em->persist($newSection);
            $this->_em->flush();
            $sections[] = $newSection;
        }

        return $sections;
    }

    protected function checkAnbefalingRapportSektion(VirksomhedRapport $entity, $rapportType) {
        $sections = $entity->getRapportSektioner($rapportType);
        $existing = $sections->filter(function($section) {
            return get_class($section) == RapportSektion::getRapportSektionClassByType('anbefaling');
        });

        if ($existing->count() >= 1) {
            return $existing->toArray();
        }

        // Creating missing sections.
        $sections = [];
        for ($i = 0; $i < 3; $i++) {
            /** @var RapportSektionRepository $sektionerRepository */
            $sektionRepository = $this->_em->getRepository('AppBundle:RapportSektioner\RapportSektion');
            /** @var RapportSektion $newSection */
            $newSection = $sektionRepository->create('anbefaling', array('rapport_type' => $rapportType));
            $entity->addRapportSektion($newSection, $rapportType);

            $this->_em->persist($newSection);
            $this->_em->flush();
            $sections[] = $newSection;
        }

        return $sections;
    }

    protected function checkTiltagRapportSektion(VirksomhedRapport $entity, $rapportType) {
        $sections = $entity->getRapportSektioner($rapportType);
        $tiltage = $entity->getBygningerRapporterTiltage();
        $tiltageRepository = $this->_em->getRepository('AppBundle:Tiltag');

        $existing = [];
        // Filtering existing section and prepare them to check.
        /** @var RapportSektion $section */
        foreach ($sections as $section) {
            if (!$section instanceof TiltagRapportSektion) {
                continue;
            }
            // Remove section if it has missing Tiltag id or it doesn't exist.
            if (empty($section->getTiltagId())
              || $tiltageRepository->find($section->getTiltagId()) == NULL
              || $tiltageRepository->findOneBy(array('id' => $section->getTiltagId()))->getTilvalgt() === FALSE
            ) {
                $this->_em->remove($section);
                $this->_em->flush();
                continue;
            }
            /** @var Bygning $bygning */
            $bygning = $section->getTiltag()->getRapport()->getBygning();
            $existing[$bygning->getId() . '_' . $section->getTiltagId()] = $section;
        }

        // Return if all section are created.
        if (count($existing) == count($tiltage)) {
            ksort($existing);
            return $existing;
        }

        // Remove already created tiltage sections.
        /** @var Tiltag $tiltag */
        foreach ($tiltage as $tiltag) {
            /** @var Bygning $bygning */
            $bygning = $tiltag->getRapport()->getBygning();
            if (isset($existing[$bygning->getId() . '_' . $tiltag->getId()])) {
                $tiltage->removeElement($tiltag);
            }
        }

        // Creating missing sections.
        $sections = $existing;
        /** @var RapportSektionRepository $sektionerRepository */
        $sektionRepository = $this->_em->getRepository('AppBundle:RapportSektioner\RapportSektion');
        /** @var Tiltag $tiltag */
        $new_sections = 0;
        foreach ($tiltage as $tiltag) {
            /** @var TiltagRapportSektion $new_sektion */
            $newSection = $sektionRepository->create('tiltag', array('tiltag' => $tiltag, 'rapport_type' => $rapportType));
            $entity->addRapportSektion($newSection, $rapportType);

            $this->_em->persist($newSection);
            $this->_em->flush();

            /** @var Bygning $bygning */
            $bygning = $tiltag->getRapport()->getBygning();
            $new_sections++;
            $sections[$bygning->getId() . '_' . $tiltag->getId()] = $newSection;
        }

        ksort($sections);
        return $sections;
    }

}
