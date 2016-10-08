<?php

namespace FBN\GuideBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Save last route from master request in session.
 */
class LastRouteListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('saveLastRouteToSession', 30),
        );
    }

    public function saveLastRouteToSession(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        // Do not save subrequests and AJAX requests
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType() || $request->isXmlHttpRequest()) {
            return;
        }

        $session = $request->getSession();

        $actualRouteName = $request->get('_route');
        $actualRouteParams = $request->get('_route_params');
        $actualRouteQueryParams = $request->query->all();

        $actualRouteData = ['name' => $actualRouteName, 'params' => array_merge($actualRouteParams, $actualRouteQueryParams)];

        $lastRouteData = $session->get('actualRouteData');
        $session->set('lastRouteData', $lastRouteData);
        $session->set('actualRouteData', $actualRouteData);
    }
}
