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
     * Get default text by text type.
     *
     * @param string $type
     *   Text type.
     *
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getDefaultText($type) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('rt')->from('AppBundle:ReportText', 'rt');
        $qb->where('rt.type = :type')
            ->andWhere('rt.standard = 1')
            ->setParameter('type', $type);
        try {
            $res = $qb->getQuery()->getSingleResult();
        }
        catch (NoResultException $e) {
            return NULL;
        }
        return $res;
    }

}
