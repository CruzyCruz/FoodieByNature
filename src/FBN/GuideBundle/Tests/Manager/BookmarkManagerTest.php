<?php

namespace FBN\GuideBundle\Tests\Manager;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use \FBN\UserBundle\Entity\User;
use FBN\GuideBundle\Entity\Bookmark;
use FBN\GuideBundle\Entity\Restaurant;
use FBN\GuideBundle\Entity\Winemaker;
use FBN\GuideBundle\Entity\Shop;
use FBN\GuideBundle\Manager\BookmarkManager;

/**
 * Unitary tests for the methods defined inside BookmarkManager.
 *
 */
class BookmarkManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get mocked token storage for user token.
     *
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        $tokenStorage = $this
            ->getMockBuilder(TokenStorageInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $tokenStorage;
    }

    /**
     * Get mocked doctrine entity manager.
     *
     * @return ObjectManager
     */
    public function getEntityManager()
    {
        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $entityManager;
    }

    /**
     * Get mocked session.
     *
     * @return Session
     */
    public function getSession()
    {
        return new Session(new MockArraySessionStorage());
    }

    /**
     * Test that bookmarkable entity addition to bookmarks is well managed.
     *
     * @dataProvider bookmarkablesEntitiesProvider
     *
     * @param FBN\GuideBundle\Entity\Restaurant|FBN\GuideBundle\Entity\Winemaker|FBN\GuideBundle\Entity\Shop $entityClass
     * @param string $bookmarkType
     */
    public function testThatBookmarkableEntityAdditionToBookmarksIsWellManaged($entityClass, $bookmarkType)
    {
        // Initiate session datas.
        $session = $this->getSession();
        $session->set('bookmarkAction', array('add'));
        $session->set('bookmarkId', array(null));
        $session->set('bookmarkEntity', array($bookmarkType));
        $session->set('bookmarkEntityId', array(1));

        // Prepare user expectations.
        $user = $this->createMock(User::class);

        $token = $this->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($user));

        $tokenStorage = $this->getTokenStorage();

        $tokenStorage->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue($token));

        // Prepare entity expectations.
        $entity = $this->createMock($entityClass);

        $entityRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($entity));

        $entityManager =  $this->getEntityManager();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($entityRepository));
        $entityManager->expects($this->once())
            ->method('persist')
            ->will($this->returnCallback(function ($bookmark) {
                if ($bookmark instanceof Bookmark) {
                    $class = new \ReflectionClass($bookmark);
                    $property = $class->getProperty('id');
                    $property->setAccessible(true);
                    $property->setValue($bookmark, 1);
                }
            }));
        $entityManager->expects($this->once())
            ->method('flush');

        // Manage bookmark.
        $bookManager = new BookmarkManager($tokenStorage, $entityManager, $session);

        $response = $bookManager->manage('add', null, $bookmarkType, 1);

        // Test the response.
        $this->assertTrue(
            $response instanceof JsonResponse,
            sprintf('After bookmark addition, the response class is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            '{"bookmarkAction":"remove","bookmarkId":1}',
            $response->getContent(),
            sprintf('After bookmark addition, the content of the response is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            'remove',
            $session->get('bookmarkAction')[0],
            sprintf('After bookmark addition, bookmarkAction set in session is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            1,
            $session->get('bookmarkId')[0],
            sprintf('After bookmark addition, bookmarkId set in session is correct for bookmarkable entity : ', $entityClass)
        );
    }

    /**
     * Bookmarkables entities providers.
     *
     * @return array array of [entityClass, bookmarkType].
     */
    public function bookmarkablesEntitiesProvider()
    {
        return  array(
            array(Restaurant::class, 'restaurant'),
            array(Winemaker::class, 'winemaker'),
            array(Shop::class, 'shop'),
        );
    }
}
