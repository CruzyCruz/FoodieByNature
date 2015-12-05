<?php

namespace FBN\GuideBundle\Bookmark;

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

    public function manage($bookmarkAction, $bookmarkId, $bookmarkEntite, $bookmarkEntiteId)
    {

        // Only authorized actions and bookmarks
        if (!in_array($bookmarkAction, $this->session->get('bookmarkAction')) || !in_array($bookmarkId, $this->session->get('bookmarkId'))) {
            return new JsonResponse('', 403);
        }

        if ($bookmarkAction == 'add') {

            // Only authorized entities
            if (!in_array($bookmarkEntite, $this->session->get('bookmarkEntite')) || !in_array($bookmarkEntiteId, $this->session->get('bookmarkEntiteId'))) {
                return new JsonResponse('', 403);
            }

            $bookmark = $this->add($bookmarkEntite, $bookmarkEntiteId);

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

    private function add($entite, $entiteId)
    {
        // To access add function user connection is mandatory du to login entry point
        $user = $this->getUser();

        $entite = ucfirst($entite);

        $repo = $this->em->getRepository('FBNGuideBundle:'.$entite);

        $instance = $repo->findOneBy(array('id' => $entiteId));

        if (null === $instance) {
            return;
        }

        $bookmark = new Bookmark();
        $bookmark->setUser($user);
        $this->accessor->setValue($bookmark, $entite, $instance);

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

    public function checkStatus($entite, $entiteId)
    {
        // Default if user is not connected
        $bookmarkAction = 'add';
        $bookmarkId = null;

        if (null !== $user = $this->getUser()) {
            if (is_object($user) || $user instanceof UserInterface) {
                $userId = $user->getId();

                $bookmark = $this->em->getRepository('FBNGuideBundle:Bookmark')
                        ->getBookmarkByEntiteId($userId, $entite, $entiteId);

                if (null !== $bookmark) {
                    $bookmarkAction = 'remove';
                    $bookmarkId = $bookmark->getId();
                }
            }
        }

        $this->setSessionVariable(array($bookmarkAction), array($bookmarkId), array($entite), array($entiteId));

        return array('bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        );
    }

    public function setSessionVariable($bookmarkAction, $bookmarkId, $entite, $entiteId)
    {
        $this->session->set('bookmarkAction', $bookmarkAction);
        $this->session->set('bookmarkId', $bookmarkId);
        $this->session->set('bookmarkEntite', $entite);
        $this->session->set('bookmarkEntiteId', $entiteId);
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
