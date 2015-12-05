<?php

namespace FBN\GuideBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FBN\GuideBundle\Entity\Article;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

        $menu = $repomenu->findOneBy(array('section' => $entite));

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

        $latlngs[] = array('lat' => $restaurant->getCoordinates()->getLatitude(), 'lng' => $restaurant->getCoordinates()->getLongitude());

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

    public function winemakerAction($slug)
    {
        $winemaker = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Winemaker')
            ->getWinemaker($slug);

        if (null === $winemaker) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        foreach ($winemaker->getWinemakerDomain() as $vd) {
            $latlngs[] = array('lat' => $vd->getCoordinates()->getLatitude(), 'lng' => $vd->getCoordinates()->getLongitude());
        }

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'winemaker');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('winemaker', $winemaker->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:winemaker.html.twig', array(
            'winemaker' => $winemaker,
            'map' => $map,
            'entite' => 'winemaker',
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        ));
    }

    public function eventAction($slug)
    {
        $event = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Event')
            ->getEvent($slug);

        if (null === $event) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        ($placeEvt = $event->getRestaurant()) || ($placeEvt = $event->getShop()) || ($placeEvt = $event->getWinemakerDomain()) || ($placeEvt = $event->getEventPast()) || ($placeEvt = $event);

        $latlngs[] = array('lat' => $placeEvt->getCoordinates()->getLatitude(), 'lng' => $placeEvt->getCoordinates()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'event');

        return $this->render('FBNGuideBundle:Guide:event.html.twig', array(
            'event' => $event,
            'placeEvt' => $placeEvt,
            'map' => $map,
        ));
    }

    public function tutorialAction($slug)
    {
        $tutorial = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Tutorial')
            ->getTutorial($slug);

        if (null === $tutorial) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        return $this->render('FBNGuideBundle:Guide:tutorial.html.twig', array(
            'tutorial' => $tutorial,
        ));
    }

    public function shopAction($slug)
    {
        $shop = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Shop')
            ->getshop($slug);

        if (null === $shop) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        ($sharedData = $shop->getRestaurant()) || ($sharedData = $shop);

        $latlngs[] = array('lat' => $sharedData->getCoordinates()->getLatitude(), 'lng' => $sharedData->getCoordinates()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'shop');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('shop', $shop->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:shop.html.twig', array(
            'shop' => $shop,
            'sharedData' => $sharedData,
            'map' => $map,
            'entite' => 'shop',
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        ));
    }

    public function bookmarksAction()
    {
        // User connexion is checked using custom LoginEntryPoint
        $userId = $this->getUser()->getId();
        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkRepo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Bookmark');

        $restaurants = $bookmarkRepo->getBookmarksByEntite($userId, 'restaurant');
        $winemakers = $bookmarkRepo->getBookmarksByEntite($userId, 'winemaker');
        $shops = $bookmarkRepo->getBookmarksByEntite($userId, 'shop');

        $bookmarks = array_merge($restaurants, $winemakers, $shops);
        $bookmarkIds = array();
        foreach ($bookmarks as $bookmark) {
            $bookmarkIds[] = $bookmark['id'];
        }

        $bookmarkManager->setSessionVariable(array('remove_only'), $bookmarkIds, array(null), array(null));

        return $this->render('FBNGuideBundle:Guide:bookmarks.html.twig', array(
            'restaurants' => $restaurants,
            'winemakers' => $winemakers,
            'shops' => $shops,
            'bookmarkIds' => $bookmarkIds,
        ));
    }

    public function bookmarkManageAction(Request $request)
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

    /**
     * Displays error pages when requested from JS.
     *
     * @param int $statusCode The HTTP header status code.
     *
     * @throws NotFoundHttpException if satus code is 404.
     * @throws AccessDeniedException if satus code is 403.
     * @throws NotFoundHttpException is user tries any other status code in adress bar.
     */
    public function displayErrorPagesAction($statusCode)
    {
        switch ($statusCode) {
            case 403:
                throw new AccessDeniedException();
                break;
            case 404:
                throw new NotFoundHttpException();
                break;
            default:
                throw new NotFoundHttpException();
        }
    }

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
