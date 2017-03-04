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
     * @var Session
     */
    private $session;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $tokenStorage;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $entityRepository;

    /**
     * Creat mock objects before each test.
     */
    public function setUp()
    {
        $this->session = new Session(new MockArraySessionStorage());
        $this->tokenStorage = $this->getMockBuilder(TokenStorageInterface::class)->disableOriginalConstructor()->getMock();
        $this->entityManager = $this->getMockBuilder(ObjectManager::class)->disableOriginalConstructor()->getMock();
        $this->entityRepository = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * Test that bookmarkable entity addition to bookmarks is well managed.
     *
     * @dataProvider bookmarkablesEntitiesProvider
     *
     * @param FBN\GuideBundle\Entity\Restaurant|FBN\GuideBundle\Entity\Winemaker|FBN\GuideBundle\Entity\Shop $entityClass
     * @param string $bookmarkEntity
     */
    public function testThatBookmarkableEntityAdditionToBookmarksIsWellManaged($entityClass, $bookmarkEntity)
    {
        $this->prepareSessiondatas(array('add'), array(null), array($bookmarkEntity), array(1));

        $this->prepareUserExceptations();

        $entity = $this->createMock($entityClass);
        $this->entityRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($entity));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository));
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->will($this->returnCallback(function ($bookmark) {
                if ($bookmark instanceof Bookmark) {
                    $this->setEntityIdByReflection($bookmark, 1);
                }
            }));
        $this->entityManager->expects($this->once())
            ->method('flush');

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('add', null, $bookmarkEntity, 1);

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
            $this->session->get('bookmarkAction')[0],
            sprintf('After bookmark addition, bookmarkAction set in session is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            1,
            $this->session->get('bookmarkId')[0],
            sprintf('After bookmark addition, bookmarkId set in session is correct for bookmarkable entity : ', $entityClass)
        );
    }

    /**
     * Test that bookmarkable entity addition to bookmarks is well managed when entity is null.
     *
     * @dataProvider bookmarkablesEntitiesProvider
     *
     * @param FBN\GuideBundle\Entity\Restaurant|FBN\GuideBundle\Entity\Winemaker|FBN\GuideBundle\Entity\Shop $entityClass
     * @param string $bookmarkEntity
     */
    public function testThatBookmarkableEntityAdditionToBookmarksIsWellManagedWhithNullEntity($entityClass, $bookmarkEntity)
    {
        $this->prepareSessiondatas(array('add'), array(null), array($bookmarkEntity), array(1));

        $this->prepareUserExceptations();

        $this->entityRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository));

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('add', null, $bookmarkEntity, 1);

        $this->checkThatResponseIsJsonWith404StatusCode($response);
    }

    /**
     * Test that bookmark removal is well managed.
     *
     * @dataProvider bookmarkablesEntitiesProvider
     *
     * @param FBN\GuideBundle\Entity\Restaurant|FBN\GuideBundle\Entity\Winemaker|FBN\GuideBundle\Entity\Shop $entityClass
     * @param string $bookmarkEntity
     */
    public function testThatBookmarkRemovalIsWellManaged($entityClass, $bookmarkEntity)
    {
        $this->prepareSessiondatas(array('remove'), array(1), array($bookmarkEntity), array(1));

        $this->playWorkFlowForBookmarkRemoval(1);

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('remove', 1, $bookmarkEntity, 1);

        $this->assertTrue(
            $response instanceof JsonResponse,
            sprintf('After bookmark removal, the response class is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            '{"bookmarkAction":"add","bookmarkId":null}',
            $response->getContent(),
            sprintf('After bookmark removal, the content of the response is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            'add',
            $this->session->get('bookmarkAction')[0],
            sprintf('After bookmark removal bookmarkAction set in session is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            null,
            $this->session->get('bookmarkId')[0],
            sprintf('After bookmark removal, bookmarkId set in session is correct for bookmarkable entity : ', $entityClass)
        );
    }

    /**
     * Test that bookmark removal is well managed when bookmark is null.
     *
     * @dataProvider bookmarkablesEntitiesProvider
     *
     * @param FBN\GuideBundle\Entity\Restaurant|FBN\GuideBundle\Entity\Winemaker|FBN\GuideBundle\Entity\Shop $entityClass
     * @param string $bookmarkEntity
     */
    public function testThatBookmarkRemovalIsWellManagedWhithNullBookmark($entityClass, $bookmarkEntity)
    {
        $this->prepareSessiondatas(array('remove'), array(1), array($bookmarkEntity), array(1));

        $this->entityRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository));

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('remove', 1, $bookmarkEntity, 1);

        $this->checkThatResponseIsJsonWith404StatusCode($response);
    }

    /**
     * Test that bookmark removal only is well managed.
     *
     * @dataProvider bookmarkablesEntitiesProvider
     *
     * @param FBN\GuideBundle\Entity\Restaurant|FBN\GuideBundle\Entity\Winemaker|FBN\GuideBundle\Entity\Shop $entityClass
     * @param string $bookmarkEntity
     */
    public function testThatBookmarkRemovalOnlyIsWellManaged($entityClass, $bookmarkEntity)
    {
        $this->prepareSessiondatas(array('remove_only'), array(1,2), array($bookmarkEntity), array(1));

        $this->playWorkFlowForBookmarkRemoval(2);

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('remove_only', 2, $bookmarkEntity, 1);

        $this->assertTrue(
            $response instanceof JsonResponse,
            sprintf('After bookmark removal only, the response class is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            1,
            count($this->session->get('bookmarkAction')),
            sprintf('After bookmark removal only, bookmarkAction set in session is correct for bookmarkable entity : ', $entityClass)
        );

        $this->assertEquals(
            1,
            $this->session->get('bookmarkId')[0],
            sprintf('After bookmark removal only, bookmarkId set in session is correct for bookmarkable entity : ', $entityClass)
        );
    }

    /**
     * Test that for unauthorized action the response status code is 403.
     */
    public function testThatUnauthorizedActionIsWellManaged()
    {
        $this->prepareSessiondatas(array('add'), array(null), array('restaurant'), array(1));

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('unauthorizedAction', null, 'restaurant', 1);

        $this->checkThatResponseIsJsonWith403StatusCode($response);
    }

    /**
     * Test that for unauthorized bookmark the response status code is 403.
     */
    public function testThatUnauthorizedBookmarkIsWellManaged()
    {
        $this->prepareSessiondatas(array('remove'), array(1), array('restaurant'), array(1));

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('remove', 2, 'restaurant', 1);

        $this->checkThatResponseIsJsonWith403StatusCode($response);
    }

    /**
     * Test that for bookmark addition and unauthorized entity the response status code is 403.
     */
    public function testThatUnauthorizedEntityForBookmarkAdditionIsWellManaged()
    {
        $this->prepareSessiondatas(array('add'), array(null), array('restaurant'), array(1));

        $bookmarkManager = new BookmarkManager($this->tokenStorage, $this->entityManager, $this->session);

        $response = $bookmarkManager->manage('add', null, 'unauthorizedEntity', 1);

        $this->checkThatResponseIsJsonWith403StatusCode($response);
    }

    /**
     * Initiate datas in session.
     *
     * @param  array $action array of strings
     * @param  array $bookmarkId array of int
     * @param  array $bookmarkEntity array of strings
     * @param  array $bookmarkEntityId array of int
     */
    private function prepareSessiondatas($action, $bookmarkId, $bookmarkEntity, $bookmarkEntityId)
    {
        $this->session->set('bookmarkAction', $action);
        $this->session->set('bookmarkId', $bookmarkId);
        $this->session->set('bookmarkEntity', $bookmarkEntity);
        $this->session->set('bookmarkEntityId', $bookmarkEntityId);
    }

    /**
     * Prepare user exceptations.
     */
    private function prepareUserExceptations()
    {
        $user = $this->createMock(User::class);

        $token = $this->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($user));

        $this->tokenStorage->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue($token));
    }

    private function playWorkFlowForBookmarkRemoval($bookmarkId)
    {
        $bookmark = new Bookmark();
        $this->setEntityIdByReflection($bookmark, $bookmarkId);

        $this->entityRepository->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue($bookmark));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository));
        $this->entityManager->expects($this->once())
            ->method('remove');
        $this->entityManager->expects($this->once())
            ->method('flush');
    }

    /**
     * Check that provided response is JsonResponse with status code 403.
     *
     * @param  JsonResponse $response
     */
    private function checkThatResponseIsJsonWith403StatusCode($response)
    {
        $this->assertTrue(
            $response instanceof JsonResponse,
            'The response class is correct.'
        );

        $this->assertEquals(
            403,
            $response->getStatusCode(),
            'The response status code is correct.'
        );
    }

    /**
     * Check that provided response is JsonResponse with status code 404.
     *
     * @param  JsonResponse $response
     */
    private function checkThatResponseIsJsonWith404StatusCode($response)
    {
        $this->assertTrue(
            $response instanceof JsonResponse,
            'The response class is correct.'
        );

        $this->assertEquals(
            404,
            $response->getStatusCode(),
            'The response status code is correct.'
        );
    }

    /**
     * Set entity Id using reflection.
     *
     * @param object $entity
     * @param int $id
     */
    private function setEntityIdByReflection($entity, $id)
    {
        $class = new \ReflectionClass($entity);
        $property = $class->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, 1);
    }

    /**
     * Bookmarkables entities providers.
     *
     * @return array array of [entityClass, bookmarkEntity].
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
