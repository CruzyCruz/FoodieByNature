<?php

namespace FBN\GuideBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FBN\GuideBundle\Entity\Article;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class GuideController extends Controller
{
    public function homeAction()
    {
        $route = $this->container->get('router')->getRouteCollection()->get('fbn_guide_articles');
        $requirements = explode('|', $route->getRequirement('articles'));

        $lastArticles = array();

        $em = $this->getDoctrine()->getManager();

        foreach ($requirements as $requirement) {
            $entity = $this->requirementToEntity($requirement);

            $articles = $em->getRepository('FBNGuideBundle:'.$entity)->getArticlesImages(0, Article::NUM_ITEMS_HOMEPAGE);
            $lastArticles = array_merge_recursive($lastArticles, $articles);
        }

        $lastArticles = array_unique($lastArticles);
        uasort($lastArticles, 'FBN\GuideBundle\Utils\Entity::compareDate');

        return $this->render('FBNGuideBundle:Guide:index.html.twig', array(
            'lastArticles' => $lastArticles,
        ));
    }

    public function articlesAction($articles)
    {
        $entity = $this->requirementToEntity($articles);

        $em = $this->getDoctrine()->getManager();

        $menuRepo = $em->getRepository('FBNGuideBundle:Menu');

        $menu = $menuRepo->findOneBy(array('section' => $entity));

        $articles = $em->getRepository('FBNGuideBundle:'.$entity)->getArticlesImages();

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

        $latlngs[] = array('lat' => $restaurant->getCoordinates()->getCoordinatesFR()->getLatitude(), 'lng' => $restaurant->getCoordinates()->getCoordinatesFR()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'restaurant');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('restaurant', $restaurant->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:restaurant.html.twig', array(
            'restaurant' => $restaurant,
            'map' => $map,
            'entity' => 'restaurant',
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
            $latlngs[] = array('lat' => $vd->getCoordinates()->getCoordinatesFR()->getLatitude(), 'lng' => $vd->getCoordinates()->getCoordinatesFR()->getLongitude());
        }

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'winemaker');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('winemaker', $winemaker->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:winemaker.html.twig', array(
            'winemaker' => $winemaker,
            'map' => $map,
            'entity' => 'winemaker',
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

        $latlngs[] = array('lat' => $placeEvt->getCoordinates()->getCoordinatesFR()->getLatitude(), 'lng' => $placeEvt->getCoordinates()->getCoordinatesFR()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'event');

        return $this->render('FBNGuideBundle:Guide:event.html.twig', array(
            'event' => $event,
            'placeEvt' => $placeEvt,
            'map' => $map,
        ));
    }

    public function tutorialAction($slug)
    {
        $locale = $this->get('request')->getLocale();

        $tutorial = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Tutorial')
            ->getTutorial($slug, $locale);

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
            ->getShop($slug);

        if (null === $shop) {
            throw $this->createNotFoundException('OUPS CA N\'EXISTE PAS !!!!');
        }

        $latlngs[] = array('lat' => $shop->getCoordinates()->getCoordinatesFR()->getLatitude(), 'lng' => $shop->getCoordinates()->getCoordinatesFR()->getLongitude());

        $map = $this->container->get('fbn_guide.map')->getMap($latlngs, 'shop');

        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkStatus = $bookmarkManager->checkStatus('shop', $shop->getId());
        $bookmarkAction = $bookmarkStatus['bookmarkAction'];
        $bookmarkId = $bookmarkStatus['bookmarkId'];

        return $this->render('FBNGuideBundle:Guide:shop.html.twig', array(
            'shop' => $shop,
            'map' => $map,
            'entity' => 'shop',
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        ));
    }

    public function bookmarksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $menuRepo = $em->getRepository('FBNGuideBundle:Menu');
        $menu = $menuRepo->findOneBy(array('section' => 'Bookmark'));

        // User connexion is checked using custom LoginEntryPoint
        $userId = $this->getUser()->getId();
        $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');
        $bookmarkRepo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('FBNGuideBundle:Bookmark');

        $restaurants = $bookmarkRepo->getBookmarksByEntity($userId, 'restaurant');
        $winemakers = $bookmarkRepo->getBookmarksByEntity($userId, 'winemaker');
        $shops = $bookmarkRepo->getBookmarksByEntity($userId, 'shop');

        $bookmarks = array_merge($restaurants, $winemakers, $shops);
        $bookmarkIds = array();
        foreach ($bookmarks as $bookmark) {
            $bookmarkIds[] = $bookmark['id'];
        }

        $bookmarkManager->setSessionVariable(array('remove_only'), $bookmarkIds, array(null), array(null));

        return $this->render('FBNGuideBundle:Guide:bookmarks.html.twig', array(
            'menu' => $menu,
            'restaurants' => $restaurants,
            'winemakers' => $winemakers,
            'shops' => $shops,
            'bookmarkIds' => $bookmarkIds,
        ));
    }

    /**
     * Manages bookmarks : add and remove actions.
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws AccessDeniedException
     */
    public function bookmarkManageAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $bookmarkAction = $request->request->get('bookmarkAction');
            $bookmarkId = $request->request->get('bookmarkId');
            $bookmarkEntity = $request->request->get('bookmarkEntity');
            $bookmarkEntityId = $request->request->get('bookmarkEntityId');

            $bookmarkManager = $this->container->get('fbn_guide.bookmark_manager');

            return  $bookmarkManager->manage($bookmarkAction, $bookmarkId, $bookmarkEntity, $bookmarkEntityId);
        }

        throw new AccessDeniedException();
    }

    /**
     * Displays error pages when requested from AJAX.
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

    public function requirementToEntity($requirement)
    {
        return ucfirst(substr($requirement, 0, strlen($requirement) - 1));
    }
}
