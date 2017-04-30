<?php

namespace FBN\GuideBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests that implement a "smoke test" of all the public and secured
 * URIs of the application. Secured URIs are the ones that require authentication.
 * URIs available once authenticated are not tested here (i.e edit profile).
 *
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider publicUrisProvider
     *
     * @param string $uri URI.
     */
    public function testPublicUris($uri)
    {
        $client = self::createClient();
        $client->request('GET', $uri);

        $this->assertTrue(
                $client->getResponse()->isSuccessful(),
                sprintf('The %s public URI loads correctly.', $uri)
        );
    }

    /**
     * @dataProvider securedUrisProvider
     *
     * @param string $uri URI.
     */
    public function testSecuredUris($uri)
    {
        $client = self::createClient();
        $client->request('GET', $uri);

        $locale = $client->getRequest()->getLocale();

        $this->assertTrue($client->getResponse()->isRedirect());

        $this->assertEquals(
            '/'.$locale.'/login',
            $client->getResponse()->getTargetUrl(),
            sprintf('The %s secured URI redirects to the login form.', $uri)
        );
    }

    /**
     * List of public URIs to be tested.
     *
     * @return array public URIs list.
     */
    public function publicUrisProvider()
    {
        return array(
            array('/en/',),
            array('/en/events',),
            array('/en/events/gourmet-in-toulouse-france-abancourt-2013',),
            array('/en/events/la-remise-france-abbeville-la-riviere-2014',),
            array('/en/events/sous-les-paves-la-vigne-france-abbecourt-2013',),
            array('/en/events/yvon-metras-at-temps-des-vendanges-france-toulouse-2013',),
            array('/en/infos',),
            array('/en/infos#a-coffee-shop-in-another-hiding',),
            array('/en/infos#good-grain',),
            array('/en/infos#paper-chewing',),
            array('/en/infos#the-force-is-with-him',),
            array('/en/login',),
            array('/en/register/',),
            array('/en/restaurants',),
            array('/en/restaurants/cantine-california-france-paris',),
            array('/en/restaurants/dix-huit-france-paris',),
            array('/en/restaurants/la-fine-mousse-france-paris',),
            array('/en/restaurants/le-temps-des-vendanges-france-toulouse',),
            array('/en/restaurants/naturellement-france-paris',),
            array('/en/shops',),
            array('/en/shops/les-caves-auge-france-abancourt',),
            array('/en/shops/les-zinzins-du-vin-france-abbeville-la-riviere',),
            array('/en/tutorials',),
            array('/en/tutorials/biodynamics',),
            array('/en/tutorials/carbonic-maceration',),
            array('/en/tutorials/labels',),
            array('/en/tutorials/the-natural-wine',),
            array('/en/winemakers',),
            array('/en/winemakers/didier-barral',),
            array('/en/winemakers/elian-da-ros',),
            array('/en/winemakers/marcel-lapierre',),
            array('/en/winemakers/robert-plageoles',),
            array('/fr/',),
            array('/fr/events',),
            array('/fr/events/la-remise-france-abbeville-la-riviere-2014',),
            array('/fr/events/repas-gastronomique-a-toulouse-france-abancourt-2013',),
            array('/fr/events/sous-les-paves-la-vigne-france-abbecourt-2013',),
            array('/fr/events/yvon-metras-au-temps-des-vendanges-france-toulouse-2013',),
            array('/fr/infos',),
            array('/fr/infos#a-coffee-shop-in-another-hiding',),
            array('/fr/infos#good-grain',),
            array('/fr/infos#paper-chewing',),
            array('/fr/infos#the-force-is-with-him',),
            array('/fr/login',),
            array('/fr/register/',),
            array('/fr/restaurants',),
            array('/fr/restaurants/cantine-california-france-paris',),
            array('/fr/restaurants/dix-huit-france-paris',),
            array('/fr/restaurants/la-fine-mousse-france-paris',),
            array('/fr/restaurants/le-temps-des-vendanges-france-toulouse',),
            array('/fr/restaurants/naturellement-france-paris',),
            array('/fr/shops',),
            array('/fr/shops/les-caves-auge-france-abancourt',),
            array('/fr/shops/les-zinzins-du-vin-france-abbeville-la-riviere',),
            array('/fr/tutorials',),
            array('/fr/tutorials/la-biodynamie',),
            array('/fr/tutorials/la-maceration-carbonique',),
            array('/fr/tutorials/le-vin-au-naturel',),
            array('/fr/tutorials/les-labels',),
            array('/fr/winemakers',),
            array('/fr/winemakers/didier-barral',),
            array('/fr/winemakers/elian-da-ros',),
            array('/fr/winemakers/marcel-lapierre',),
            array('/fr/winemakers/robert-plageoles',),
        );
    }

    /**
     * List of secured URIs to be tested.
     *
     * @return array secured URIs list.
     */
    public function securedUrisProvider()
    {
        return array(
            array('/en/bookmarks'),
            array('/fr/bookmarks'),
            array('/en/admin'),
            array('/fr/admin')
        );
    }
}
