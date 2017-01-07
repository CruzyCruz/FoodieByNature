<?php

namespace FBN\GuideBundle\Manager;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use FBN\GuideBundle\Entity\Bookmark;

class BookmarkManager
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManager $em, Session $session)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
        $this->session = $session;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function manage($bookmarkAction, $bookmarkId, $bookmarkEntity, $bookmarkEntityId)
    {
        // Only authorized actions and bookmarks
        if (!in_array($bookmarkAction, $this->session->get('bookmarkAction')) || !in_array($bookmarkId, $this->session->get('bookmarkId'))) {
            return new JsonResponse('', 403);
        }

        if ($bookmarkAction == 'add') {
            // Only authorized entities
            if (!in_array($bookmarkEntity, $this->session->get('bookmarkEntity')) || !in_array($bookmarkEntityId, $this->session->get('bookmarkEntityId'))) {
                return new JsonResponse('', 403);
            }

            $bookmark = $this->add($bookmarkEntity, $bookmarkEntityId);

            if (null === $bookmark) {
                return new JsonResponse('', 404);
            }

            $bookmarkId = $bookmark->getId();

            $this->session->set('bookmarkAction', array('remove'));
            $this->session->set('bookmarkId', array($bookmarkId));

            return new JsonResponse(array('bookmarkAction' => 'remove',
                'bookmarkId' => $bookmarkId,
            ));
        } elseif ($bookmarkAction == 'remove') {
            $bookmark = $this->remove($bookmarkId);

            if (null === $bookmark) {
                return new JsonResponse('', 404);
            }

            $bookmarkId = null;

            $this->session->set('bookmarkAction', array('add'));
            $this->session->set('bookmarkId', array($bookmarkId));

            return new JsonResponse(array('bookmarkAction' => 'add',
                'bookmarkId' => $bookmarkId,
            ));
        } elseif ($bookmarkAction == 'remove_only') {
            $this->remove($bookmarkId);

            $bookmarkIds = $this->session->get('bookmarkId');
            $bookmarkIdKey = array_search($bookmarkId, $bookmarkIds);
            unset($bookmarkIds[$bookmarkIdKey]);
            $this->session->set('bookmarkId', $bookmarkIds);

            return new JsonResponse(array('bookmarkId' => $bookmarkId));
        }
    }

    private function add($entity, $entityId)
    {
        // To access add function user connection is mandatory du to login entry point
        $user = $this->getUser();

        $entity = ucfirst($entity);

        $repo = $this->em->getRepository('FBNGuideBundle:'.$entity);

        $instance = $repo->findOneBy(array('id' => $entityId));

        if (null === $instance) {
            return;
        }

        $bookmark = new Bookmark();
        $bookmark->setUser($user);
        $this->accessor->setValue($bookmark, $entity, $instance);

        $this->em->persist($bookmark);
        $this->em->flush();

        return $bookmark;
    }

    private function remove($bookmarkId)
    {
        $bookmark = $this->em->getRepository('FBNGuideBundle:Bookmark')
            ->findOneBy(array('id' => $bookmarkId));

        if (null === $bookmark) {
            return;
        }

        $this->em->remove($bookmark);
        $this->em->flush();

        return $bookmark;
    }

    public function checkStatus($entity, $entityId)
    {
        // Default if user is not connected
        $bookmarkAction = 'add';
        $bookmarkId = null;

        if (null !== $user = $this->getUser()) {
            if (is_object($user) || $user instanceof UserInterface) {
                $userId = $user->getId();

                $bookmark = $this->em->getRepository('FBNGuideBundle:Bookmark')
                        ->getBookmarkByEntityId($userId, $entity, $entityId);

                if (null !== $bookmark) {
                    $bookmarkAction = 'remove';
                    $bookmarkId = $bookmark->getId();
                }
            }
        }

        $this->setSessionVariable(array($bookmarkAction), array($bookmarkId), array($entity), array($entityId));

        return array('bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        );
    }

    public function setSessionVariable($bookmarkAction, $bookmarkId, $entity, $entityId)
    {
        $this->session->set('bookmarkAction', $bookmarkAction);
        $this->session->set('bookmarkId', $bookmarkId);
        $this->session->set('bookmarkEntity', $entity);
        $this->session->set('bookmarkEntityId', $entityId);
    }

    private function getUser()
    {
        $securityToken = $this->tokenStorage->getToken();

        if (null !== $securityToken) {
            return $securityToken->getUser();
        }

        return;
    }
}
