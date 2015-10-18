<?php

namespace FBN\GuideBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FBN\GuideBundle\Entity\Article;

class GuideController extends Controller
{
    public function accueilAction()
    {
        $route = $this->container->get('router')->getRouteCollection()->get('fbn_guide_articles');
        $requirements = explode('|', $route->getRequirement('articles'));

        $lastarticles = new \ArrayObject();

        $em = $this->getDoctrine()->getManager();

        foreach ($requirements as $requirement) {
            $entite = $this->requirementToEntity($requirement);

            $articles = $em->getRepository('FBNGuideBundle:'.$entite)->getArticlesImages(0, Article::NUM_ITEMS_HOMEPAGE);

            foreach ($articles as $article) {
                $lastarticles->append($article);
            }
        }

        $lastarticles->uasort('FBN\GuideBundle\Controller\GuideController::compareDate');

        return $this->render('FBNGuideBundle:Guide:index.html.twig', array(
            'lastarticles' => $lastarticles,
        ));
    }

    public function articlesAction($articles)
    {
        $entite = $this->requirementToEntity($articles);

        $em = $this->getDoctrine()->getManager();

        $repomenu = $em->getRepository('FBNGuideBundle:Menu');

        $menu = $repomenu->findOneBy(array('entite' => $entite));

        $articles = $em->getRepository('FBNGuideBundle:'.$entite)->getArticlesImages();

        return $this->render('FBNGuideBundle:Guide:articles.html.twig', array(
            'menu' => $menu,
            'articles' => $articles,
        ));
    }

    public function restaurantAction($slug)
    {
        $restaurant = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Restaurant')
            ->getRestaurant($slug);

        if (null === $restaurant) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        $latlngs[] = array('lat' => $restaurant->getCoordonnees()->getLatitude(), 'lng' => $restaurant->getCoordonnees()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'restaurant');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('restaurant', $restaurant->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:restaurant.html.twig', array(
            'restaurant' => $restaurant,
            'map' => $map,
            'entite' => 'restaurant',
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        ));
    }

    public function vigneronAction($slug)
    {
        $vigneron = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Vigneron')
            ->getVigneron($slug);

        if (null === $vigneron) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        foreach ($vigneron->getVigneronDomaine() as $vd) {
            $latlngs[] = array('lat' => $vd->getCoordonnees()->getLatitude(), 'lng' => $vd->getCoordonnees()->getLongitude());
        }

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'vigneron');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('vigneron', $vigneron->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:vigneron.html.twig', array(
            'vigneron' => $vigneron,
            'map' => $map,
            'entite' => 'vigneron',
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        ));
    }

    public function evenementAction($slug)
    {
        $evenement = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Evenement')
            ->getEvenement($slug);

        if (null === $evenement) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        ($lieuevt = $evenement->getRestaurant()) || ($lieuevt = $evenement->getCaviste()) || ($lieuevt = $evenement->getVigneronDomaine()) || ($lieuevt = $evenement->getEvenementPast()) || ($lieuevt = $evenement);

        $latlngs[] = array('lat' => $lieuevt->getCoordonnees()->getLatitude(), 'lng' => $lieuevt->getCoordonnees()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'evenement');

        return $this->render('FBNGuideBundle:Guide:evenement.html.twig', array(
            'evenement' => $evenement,
            'lieuevt' => $lieuevt,
            'map' => $map,
        ));
    }

    public function tutorielAction($slug)
    {
        $tutoriel = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Tutoriel')
            ->getTutoriel($slug);

        if (null === $tutoriel) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        return $this->render('FBNGuideBundle:Guide:tutoriel.html.twig', array(
            'tutoriel' => $tutoriel,
        ));
    }

    public function cavisteAction($slug)
    {
        $caviste = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Caviste')
            ->getcaviste($slug);

        if (null === $caviste) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        ($sharedData = $caviste->getRestaurant()) || ($sharedData = $caviste);

        $latlngs[] = array('lat' => $sharedData->getCoordonnees()->getLatitude(), 'lng' => $sharedData->getCoordonnees()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'caviste');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('caviste', $caviste->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:caviste.html.twig', array(
            'caviste' => $caviste,
            'sharedData' => $sharedData,
            'map' => $map,
            'entite' => 'caviste',
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        ));
    }

    public function favorisAction()
    {
        // User connexion is checked using custom LoginEntryPoint
        $userId = $this->getUser()->getId();
        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $favoriRepo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Favori');

        $restaurants = $favoriRepo->getFavorisByEntite($userId, 'restaurant');
        $vignerons = $favoriRepo->getFavorisByEntite($userId, 'vigneron');
        $cavistes = $favoriRepo->getFavorisByEntite($userId, 'caviste');

        $bookmarks = array_merge($restaurants, $vignerons, $cavistes);
        $bookmarkIds = array();
        foreach ($bookmarks as $bookmark) {
            $bookmarkIds[] = $bookmark['id'];
        }

        $bookmarkManager->setSessionVariable(array('remove_only'), $bookmarkIds, array(null), array(null));

        return $this->render('FBNGuideBundle:Guide:favoris.html.twig', array(
            'restaurants' => $restaurants,
            'vignerons' => $vignerons,
            'cavistes' => $cavistes,
            'bookmarkIds' => $bookmarkIds,
        ));
    }

    public function favoriManageAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $bookmarkAction = $request->request->get('bookmarkAction');
            $bookmarkId = $request->request->get('bookmarkId');
            $bookmarkEntite = $request->request->get('bookmarkEntite');
            $bookmarkEntiteId = $request->request->get('bookmarkEntiteId');

            $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');

            return  $bookmarkManager->manage($bookmarkAction, $bookmarkId, $bookmarkEntite, $bookmarkEntiteId);
        }
    }

    // Fonction de comparaison des dates
    public static function compareDate($a, $b)
    {
        $d1 = $a->getDatePublication();
        $d2 = $b->getDatePublication();

        if ($d1 == $d2) {
            return 0;
        }

        return ($d1 > $d2) ? -1 : 1;
    }

    public function requirementToEntity($requirement)
    {
        return ucfirst(substr($requirement, 0, strlen($requirement) - 1));
    }
}
