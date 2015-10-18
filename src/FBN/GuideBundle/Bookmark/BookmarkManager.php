<?php

namespace FBN\GuideBundle\Bookmark;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use FBN\GuideBundle\Entity\Favori;

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

    public function manage($bookmarkAction, $bookmarkId, $bookmarkEntite, $bookmarkEntiteId) {           

        // Only authorized actions and bookmarks
        if (!in_array($bookmarkAction, $this->session->get('bookmarkAction')) || !in_array($bookmarkId, $this->session->get('bookmarkId'))) {
            return new JsonResponse('',403); 
        }                        

        if ($bookmarkAction == 'add') {                              

            // Only authorized entities
            if (!in_array($bookmarkEntite, $this->session->get('bookmarkEntite')) || !in_array($bookmarkEntiteId, $this->session->get('bookmarkEntiteId'))) {
                return new JsonResponse('',403); 
            }                
          
            $favori = $this->add($bookmarkEntite, $bookmarkEntiteId);                
            $bookmarkId = $favori->getId();

            $this->session->set('bookmarkAction', array('remove'));
            $this->session->set('bookmarkId', array($bookmarkId));

            return new JsonResponse(array('bookmarkAction' => 'remove',
                'bookmarkId' => $bookmarkId,
            ));
        }
        elseif($bookmarkAction == 'remove') {
            $this->remove($bookmarkId);

            $bookmarkId = null;

            $this->session->set('bookmarkAction', array('add'));
            $this->session->set('bookmarkId', array($bookmarkId));

            return new JsonResponse(array('bookmarkAction' => 'add',
                'bookmarkId' => $bookmarkId,
            ));                    
        }
        elseif($bookmarkAction == 'remove_only') {
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

        $repo = $this->em->getRepository('FBNGuideBundle:' . $entite);

        $instance = $repo->findOneBy(array('id' => $entiteId));

        $favori = new Favori();
        $favori->setUser($user);
        $this->accessor->setValue($favori, $entite, $instance);        

        $this->em->persist($favori); 
        $this->em->flush();

        return $favori;         
    }  

    private function remove($bookmarkId)
    {
        $favori = $this->em->getRepository('FBNGuideBundle:Favori')
            ->findOneBy(array('id' => $bookmarkId));            

        $this->em->remove($favori);
        $this->em->flush();
    }       

    public function checkStatus($entite, $entiteId)
    {
        // Default if user is not connected
        $bookmarkAction = 'add';
        $bookmarkId = null;

        if(null !== $user = $this->getUser())
        {
	        if (is_object($user) || $user instanceof UserInterface) {            
	            $userId = $user->getId();

	            $favori = $this->em->getRepository('FBNGuideBundle:Favori')
	                    ->getFavoriByEntiteId($userId, $entite, $entiteId);	                    

	            if(null !== $favori) {
	                $bookmarkAction = 'remove';
	                $bookmarkId = $favori->getId();
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

        if (null !== $securityToken)
        {
            return $securityToken->getUser();
        }

        return null;
    }    
}