<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FavoriRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FavoriRepository extends EntityRepository
{
    public function getFavoriByEntiteId($userId, $entite, $entiteId)
    {
        $qb = $this->createQueryBuilder('f')
                    ->where('f.user = :user_id')
                    ->setParameter('user_id', $userId)
                    ->andwhere('f.'.$entite.' = :entite_id')
                    ->setParameter('entite_id', $entiteId);

        return $qb->getQuery()
            ->getOneOrNullResult();
    }

    public function getFavorisByEntite($userId, $entite)
    {
        // Using join to only take data with correspondances
        $qb = $this->createQueryBuilder('f')
                    ->where('f.user = :user_id')
                    ->setParameter('user_id', $userId)
                   ->join('f.'.$entite, 'fr')
                   ->addSelect('fr');

        return $qb->getQuery()
            ->getArrayResult();
    }
}
