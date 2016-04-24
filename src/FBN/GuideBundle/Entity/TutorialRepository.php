<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TutorialRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TutorialRepository extends EntityRepository
{
    public function getArticlesImages($first = 0, $limit = Article::NUM_ITEMS)
    {
        $qb = $this->createQueryBuilder('t')
                   ->leftJoin('t.image', 'i')
                   ->addSelect('i')
                   ->orderBy('t.datePublication', 'DESC')
                    ->where('t.publication = :publication')
                    ->setParameter('publication', 1);

        $query = $qb->getQuery();

        $query->setFirstResult($first)
              ->setMaxResults($limit);

        return $query->getResult();
    }

    public function getTutorial($slug)
    {
        $qb = $this->createQueryBuilder('t')
                   ->leftJoin('t.image', 'i')
                   ->addSelect('i')
                   ->leftJoin('t.tutorialSection', 'tr')
                   ->addSelect('tr')
                   ->leftJoin('t.tutorialChapter', 'tc')
                   ->addSelect('tc')
                   ->leftJoin('tc.tutorialChapterParas', 'tcp')
                   ->addSelect('tcp')
                    ->where('t.slug = :slug')
                    ->setParameter('slug', $slug);

        return $qb->getQuery()
                  ->getOneOrNullResult();
    }
}
