<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RestaurantRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RestaurantRepository extends EntityRepository
{
    public function getArticlesImages($first = 0, $limit = Article::NUM_ITEMS)
    {
        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.image', 'i')
            ->addSelect('i')
            ->orderBy('r.datePublication', 'DESC')
            ->andWhere('r.publication = :publication')
            ->setParameter('publication', true);

        $query = $qb->getQuery();

        $query->setFirstResult($first)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    public function getRestaurantShops($first = 0, $limit = Article::NUM_ITEMS)
    {
        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.image', 'i')
            ->addSelect('i')
            ->orderBy('r.datePublication', 'DESC')
            ->andWhere('r.isShop = :isShop')
            ->setParameter('isShop', true)
            ->andWhere('r.publication = :publication')
            ->setParameter('publication', true);

        $query = $qb->getQuery();

        $query->setFirstResult($first)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    public function getRestaurant($slug)
    {
        $qb = $this->createQueryBuilder('r')
                ->leftJoin('r.image', 'i')
                ->addSelect('i')
                ->leftJoin('r.restaurantPrice', 'rp')
                ->addSelect('rp')
                ->leftJoin('r.restaurantStyle', 'rs')
                ->addSelect('rs')
                ->leftJoin('r.restaurantBonus', 'rb')
                ->addSelect('rb')
                ->leftJoin('r.coordinates', 'c')
                ->addSelect('c')
                ->andWhere('r.publication = :publication')
                ->setParameter('publication', true)
                ->andWhere('r.slug = :slug')
                ->setParameter('slug', $slug);

        $cr = $this->_em
                ->getRepository('FBNGuideBundle:Coordinates');

        $qb = $cr->joinCoord($qb);

        return $qb->getQuery()
                ->getOneOrNullResult();
    }

    public function getRestaurantShop($slug)
    {
        $qb = $this->createQueryBuilder('r')
                ->leftJoin('r.image', 'i')
                ->addSelect('i')
                ->leftJoin('r.coordinates', 'c')
                ->addSelect('c')
                ->andWhere('r.publication = :publication')
                ->setParameter('publication', true)
                ->andWhere('r.isShop = :isShop')
                ->setParameter('isShop', true)
                ->andWhere('r.slug = :slug')
                ->setParameter('slug', $slug);

        $cr = $this->_em
                ->getRepository('FBNGuideBundle:Coordinates');

        $qb = $cr->joinCoord($qb);

        return $qb->getQuery()
                ->getOneOrNullResult();
    }
}
