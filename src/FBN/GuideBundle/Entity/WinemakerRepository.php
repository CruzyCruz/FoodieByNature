<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * WinemakerRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WinemakerRepository extends EntityRepository
{
    public function getArticlesImages($first = 0, $limit = Article::NUM_ITEMS)
    {
        $qb = $this->createQueryBuilder('v')
                   ->leftJoin('v.image', 'i')
                   ->addSelect('i')
                   ->orderBy('v.datePublication', 'DESC')
                    ->where('v.publication = :publication')
                    ->setParameter('publication', 1);

        $query = $qb->getQuery();

        $query->setFirstResult($first)
              ->setMaxResults($limit);

        return $query->getResult();
    }

    public function getWinemaker($slug)
    {
        $qb = $this->createQueryBuilder('v')
                   ->leftJoin('v.image', 'i')
                   ->addSelect('i')
                   ->leftJoin('v.winemakerDomain', 'vd')
                   ->addSelect('vd')
                   ->leftJoin('vd.winemakerArea', 'vr')
                   ->addSelect('vr')
                   ->leftJoin('vd.coordinates', 'c')
                   ->addSelect('c')
                    ->where('v.slug = :slug')
                    ->setParameter('slug', $slug);

        $cr = $this->_em
                    ->getRepository('FBNGuideBundle:Coordinates');

        $qb = $cr->joinCoord($qb);

        return $qb->getQuery()
                  ->getOneOrNullResult();
    }
}
