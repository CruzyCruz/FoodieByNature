<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * EvenementRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvenementRepository extends EntityRepository
{
    public function getArticlesImages($first = 0, $limit = Article::NUM_ITEMS)
    {
        $qb = $this->createQueryBuilder('e')
                   ->leftJoin('e.image', 'i')
                   ->addSelect('i')
                   ->orderBy('e.datePublication', 'DESC')
                    ->where('e.publication = :publication')
                    ->setParameter('publication', 1);

        $query = $qb->getQuery();

        $query->setFirstResult($first)
              ->setMaxResults($limit);

        return new Paginator($query);
    }

    public function getEvenement($slug)
    {
        $qb = $this->createQueryBuilder('e')
                   ->leftJoin('e.image', 'i')
                   ->addSelect('i')
                   ->leftJoin('e.evenementType', 'et')
                   ->addSelect('et')
                   ->leftJoin('e.eventPast', 'ep')
                   ->addSelect('ep')
                   ->leftJoin('e.restaurant', 'er')
                   ->addSelect('er')
                   ->leftJoin('e.caviste', 'ec')
                   ->addSelect('ec')
                   ->leftJoin('e.winemakerDomain', 'ev')
                   ->addSelect('ev')
                   ->leftJoin('ev.winemaker', 'evv')
                   ->addSelect('evv')
                   ->leftJoin('e.coordonnees', 'c')
                   ->addSelect('c')
                    ->where('e.slug = :slug')
                    ->setParameter('slug', $slug);

        $cr = $this->_em
                    ->getRepository('FBNGuideBundle:Coordonnees');

        $qb = $cr->joinCoord($qb);

        return $qb->getQuery()
                  ->getOneOrNullResult();
    }
}
