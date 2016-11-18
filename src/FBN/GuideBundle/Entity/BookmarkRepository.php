<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BookmarkRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookmarkRepository extends EntityRepository
{
    public function getBookmarkByEntityId($userId, $entity, $entityId)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.user = :user_id')
            ->setParameter('user_id', $userId)
            ->andWhere('b.'.$entity.' = :entity_id')
            ->setParameter('entity_id', $entityId);

        return $qb->getQuery()
            ->getOneOrNullResult();
    }

    public function getBookmarksByEntity($userId, $entity)
    {
        // Using join to only take data with correspondances
        $qb = $this->createQueryBuilder('b')
            ->where('b.user = :user_id')
            ->setParameter('user_id', $userId)
            ->join('b.'.$entity, 'ba')
            ->addSelect('ba')
            ->andWhere('ba.publication = :publication')
            ->setParameter('publication', true);

        return $qb->getQuery()
            ->getArrayResult();
    }
}
