<?php

namespace FBN\GuideBundle\Tests\Utils;

use PHPUnit\Framework\TestCase;
use FBN\GuideBundle\Utils\Entity;
use FBN\GuideBundle\Entity\Article;

/**
 * Unitary tests for the methods defined inside Entity utility class.
 */
class EntityTest extends TestCase
{
    /**
     * Test that article entity date publication comparisons are corrects.
     */
    public function testCompareDate()
    {
        $article1 = $this->createMock(Article::class);
        $article1->method('getDatePublication')
            ->willReturn(new \DateTime('2000-01-01'));

        $article2 = $this->createMock(Article::class);
        $article2->method('getDatePublication')
            ->willReturn(new \DateTime('2001-01-01'));

        $int = Entity::compareDate($article1, $article2);

        $this->assertEquals(1, $int);

        $int = Entity::compareDate($article2, $article1);

        $this->assertEquals(-1, $int);

        $int = Entity::compareDate($article2, $article2);

        $this->assertEquals(0, $int);
    }
}
