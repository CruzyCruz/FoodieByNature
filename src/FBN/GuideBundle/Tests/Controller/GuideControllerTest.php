<?php

namespace FBN\GuideBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use FBN\GuideBundle\Entity\Article;

/**
 * Functional test for the controllers defined inside GuideController.
 */
class GuideControllerTest extends WebTestCase
{
    /**
     * Application locales.
     *
     * @var array locales.
     */
    private static $locales = array('en', 'fr');

    /**
     * Secured homepage URIs or available from homepage if user is connected with minimum required role.
     *
     * @var array array of [URI, role].
     */
    private static $securedUrisAndRoles =
        array(
            array('http://localhost/en/bookmarks', 'ROLE_USER'),
            array('http://localhost/fr/bookmarks', 'ROLE_USER'),
            array('http://localhost/en/profile/edit-all', 'ROLE_USER'),
            array('http://localhost/fr/profile/edit-all', 'ROLE_USER'),
            array('http://localhost/en/logout', 'ROLE_USER'),
            array('http://localhost/fr/logout', 'ROLE_USER'),
        );

    /**
     * Roles hierarchy from minor to major.
     *
     * @var array roles.
     */
    private static $rolesHierarchy = array(
        'IS_AUTHENTICATED_ANONYMOUSLY',
        'ROLE_USER',
        'ROLE_AUTHOR',
        'ROLE_ADMIN',
        );

    /**
     * Correspondence between routing fbn_guide_articles {articles} requirements and entity.
     *
     * @var array
     */
    private static $articlesEntities = array(
        'infos' => 'FBN\GuideBundle\Entity\Info',
        'restaurants' => 'FBN\GuideBundle\Entity\Restaurant',
        'winemakers' => 'FBN\GuideBundle\Entity\Winemaker',
        'events' => 'FBN\GuideBundle\Entity\Event',
        'tutorials' => 'FBN\GuideBundle\Entity\Tutorial',
        'shops' => 'FBN\GuideBundle\Entity\Shop',
    );

    /**
     * @dataProvider usersProvider
     *
     * Test all links on homepage versus the different possible kind of users.
     * Nota : some links could only be available in homepage template for certains user (i.e "admin" for author and admin users).
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testHomePageLinks($user, $password, $role)
    {
        foreach (self::$locales as $locale) {
            $client = $this->getClientForUser($user, $password);

            $crawler = $client->request('GET', '/'.$locale.'/');

            $this->assertTrue($client->getResponse()->isSuccessful());

            $links = $crawler->filter('a')->links();
            $nbLinks = count($links);
            $linkCounter = 0;
            $logoutLink = null;

            foreach ($links as $link) {
                $roleForUri = 'IS_AUTHENTICATED_ANONYMOUSLY';
                // Find minimum role required for URI associated to this link.
                $uri = $link->getUri();
                $key = array_search($uri, array_column(self::$securedUrisAndRoles, 0));
                // If the URI is secured.
                if (false !== $key) {
                    $roleForUri = self::$securedUrisAndRoles[$key][1];
                }

                // Find hierarchical position for this role
                $rolePositionForUri = array_search($roleForUri, self::$rolesHierarchy);

                // Find hierarchical position for role of actual user
                $rolePosition = array_search($role, self::$rolesHierarchy);

                // If a user is authenticated, report the click on logout link at the end of the process.
                if ('http://localhost/'.$locale.'/logout' === $uri) {
                    $logoutLink = $link;
                } else {
                    $client->click($link);
                    $linkCounter = $linkCounter + 1;

                    if ($rolePosition < $rolePositionForUri) {
                        $this->assertTrue($client->getResponse()->isRedirect());

                        $this->assertEquals(
                            '/'.$locale.'/login',
                            $client->getResponse()->getTargetUrl(),
                            sprintf('The %s secure URI redirects to the login form.', $uri)
                        );
                    } else {
                        $this->assertTrue(
                            $client->getResponse()->isSuccessful(),
                            sprintf('The %s URI loads correctly.', $uri)
                        );
                    }
                }
            }

            // End clicking process by clicking on logout link if necessary.
            if (null !== $logoutLink) {
                $client->click($logoutLink);
                $linkCounter = $linkCounter + 1;

                $this->assertTrue($client->getResponse()->isRedirect());

                $this->assertEquals(
                        'http://localhost/'.$locale.'/',
                        $client->getResponse()->getTargetUrl(),
                        sprintf('The %s URI redirects to the homepage.', $uri)
                );
            }

            $this->assertEquals(
                $nbLinks,
                $linkCounter,
                sprintf('%s links clicked vs % links found on page.', $nbLinks, $linkCounter)
            );
        }
    }

    /**
     * @dataProvider usersProvider
     *
     * Test that homepage displays the correct number of link articles vs the different possible kind of users.
     */
    public function testHomePageHasTheCorrectNumberOfLinksToArticles($user, $password)
    {
        foreach (self::$locales as $locale) {
            $client = $this->getClientForUser($user, $password);

            $crawler = $client->request('GET', '/'.$locale.'/');

            $this->assertLessThanOrEqual(
                Article::NUM_KIND_OF_ARTICLES * Article::NUM_ITEMS_HOMEPAGE,
                $crawler->filter('#content a')->count(),
                'The homepage displays the correct number of links to articles.'
            );
        }
    }

    /**
     * @dataProvider usersProvider
     *
     * Test that articles page (restaurants, events,...) displays the correct number of link articles vs the different possible kind of users.
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testArticlesPageHasTheCorrectNumberOfArticlesOrLinksToArticles($user, $password)
    {
        foreach (self::$locales as $locale) {
            $client = $this->getClientForUser($user, $password);

            foreach (self::$articlesEntities as $articles => $entity) {
                $crawler = $client->request('GET', '/'.$locale.'/'.$articles);

                $this->assertTrue($client->getResponse()->isSuccessful());

                if ($entity === 'FBN\GuideBundle\Entity\Info') {
                    $this->assertCount(
                        $entity::NUM_ITEMS,
                        $crawler->filter('h1'),
                        sprintf('The %s page displays the correct number of articles.', $articles)
                    );
                } else {
                    $this->assertCount(
                        $entity::NUM_ITEMS,
                        $crawler->filter('#content a'),
                        sprintf('The %s page displays the correct number of links to articles.', $articles)
                    );
                }
            }
        }
    }

    /**
     * @dataProvider usersProvider
     *
     * Test that for one restaurant page the article is correctly displayed and translated vs the different possible kind of users.
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testRestaurantTheArticleIsCorrectlyDiplayedAndTranslated($user, $password)
    {
        $client = $this->getClientForUser($user, $password);

        // (en)
        $locale = 'en';

        $crawler = $client->request('GET', '/'.$locale.'/restaurants/le-temps-des-vendanges-france-toulouse');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("An apparition that will have the inhabitants of Belleville")')->count(),
            sprintf('The (%s) restaurant article is correct', $locale)
        );

        // (fr)
        $locale = 'fr';

        $crawler = $client->request('GET', '/'.$locale.'/restaurants/le-temps-des-vendanges-france-toulouse');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Une apparition qui va combler les Bellevillois")')->count(),
            sprintf('The (%s) restaurant article is correct', $locale)
        );
    }

    /**
     * @dataProvider usersProvider
     *
     * Test that for one winemaker page the article is correctly displayed and translated vs the different possible kind of users.
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testWinemakerTheArticleIsCorrectlyDiplayedAndTranslated($user, $password)
    {
        $client = $this->getClientForUser($user, $password);

        // (en)
        $locale = 'en';

        $crawler = $client->request('GET', '/'.$locale.'/winemakers/didier-barral');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Didier Barral has come a long way since its installation")')->count(),
            sprintf('The (%s) winemaker article is correct', $locale)
        );

        // (fr)
        $locale = 'fr';

        $crawler = $client->request('GET', '/'.$locale.'/winemakers/didier-barral');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Didier Barral a parcouru un long chemin depuis son installation")')->count(),
            sprintf('The (%s) winemaker article is correct', $locale)
        );
    }

    /**
     * @dataProvider usersProvider
     *
     * Test that for one tutorial page the article is correctly displayed and translated vs the different possible kind of users.
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testTutorialTheArticleIsCorrectlyDiplayedAndTranslated($user, $password)
    {
        $client = $this->getClientForUser($user, $password);

        // (en)
        $locale = 'en';

        $crawler = $client->request('GET', '/'.$locale.'/tutorials/the-natural-wine');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("There are about 3,000 wineries in France")')->count(),
            sprintf('The (%s) tutorial article is correct', $locale)
        );

        // (fr)
        $locale = 'fr';

        $crawler = $client->request('GET', '/'.$locale.'/tutorials/le-vin-au-naturel');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Il existe en France environ 3000 vignerons")')->count(),
            sprintf('The (%s) tutorial article is correct', $locale)
        );
    }

    /**
     * @dataProvider usersProvider
     *
     * Test that for one event page the article is correctly displayed and translated vs the different possible kind of users.
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testEventTheArticleIsCorrectlyDiplayedAndTranslated($user, $password)
    {
        $client = $this->getClientForUser($user, $password);

        // (en)
        $locale = 'en';

        $crawler = $client->request('GET', '/'.$locale.'/events/yvon-metras-at-temps-des-vendanges-france-toulouse-2013');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("At Temps des Vendanges, this Saturday")')->count(),
            sprintf('The (%s) restaurantevent article is correct', $locale)
        );

        // (fr)
        $locale = 'fr';

        $crawler = $client->request('GET', '/'.$locale.'/events/yvon-metras-au-temps-des-vendanges-france-toulouse-2013');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Au Temps des Vendanges ce Samedi")')->count(),
            sprintf('The (%s) event article is correct', $locale)
        );
    }

    /**
     * @dataProvider usersProvider
     *
     * Test that for one shop page the article is correctly displayed and translated vs the different possible kind of users.
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testShopTheArticleIsCorrectlyDiplayedAndTranslated($user, $password)
    {
        $client = $this->getClientForUser($user, $password);

        // (en)
        $locale = 'en';

        $crawler = $client->request('GET', '/'.$locale.'/shops/les-caves-auge-france-abancourt');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("From noon to 2:30pm (except Saturday) and from 7:30pm to 11pm. Closed Sunday.")')->count(),
            sprintf('The (%s) shop article is correct', $locale)
        );

        // (fr)
        $locale = 'fr';

        $crawler = $client->request('GET', '/'.$locale.'/shops/les-caves-auge-france-abancourt');

        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("De midi à 14h30 (sauf samedi) et de 19h30 à 23h. Fermé dimanche.")')->count(),
            sprintf('The (%s) shop article is correct', $locale)
        );
    }

    /**
     * Test that each error page is correctly displayed  vs the different possible kind of users.
     *
     * @dataProvider usersProvider
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testDisplayErrorPages($user, $password)
    {
        foreach (self::$locales as $locale) {
            $client = $this->getClientForUser($user, $password);
            // String with a minimum length of 4 (> length(403) or length(404))
            $randomString = 'test'.uniqid();

            if ('anonymous' === $user) {
                $crawler = $client->request('GET', '/'.$locale.'/error/403');
                $this->assertTrue($client->getResponse()->isRedirect());
                $this->assertEquals(
                    '/'.$locale.'/login',
                    $client->getResponse()->getTargetUrl(),
                    sprintf('The (%s) error page 403 redirects to the login form.', $locale)
                );
                $crawler = $client->request('GET', '/'.$locale.'/error/404');
                $this->assertEquals(404, $client->getResponse()->getStatusCode());
                $crawler = $client->request('GET', '/'.$locale.'/error/'.$randomString);
                $this->assertEquals(404, $client->getResponse()->getStatusCode());
            } else {
                $crawler = $client->request('GET', '/'.$locale.'/error/403');
                $this->assertEquals(403, $client->getResponse()->getStatusCode());
                $crawler = $client->request('GET', '/'.$locale.'/error/404');
                $this->assertEquals(404, $client->getResponse()->getStatusCode());
                $crawler = $client->request('GET', '/'.$locale.'/error/'.$randomString);
                $this->assertEquals(404, $client->getResponse()->getStatusCode());
            }
        }
    }

    /**
     * Test that for each kind of boorkmable article the bookmarks are correctly recorded ad removed vs the different possible kind of users.
     *
     * @dataProvider usersProvider
     *
     * @param string      $user
     * @param null|string $password
     */
    public function testBookmarks($user, $password)
    {
        foreach (self::$locales as $locale) {
            $client = $this->getClientForUser($user, $password);

            if ('anonymous' === $user) {
                // Check that accessing bookmarks for anonymous user redirects to login page.
                $crawler = $client->request('GET', '/'.$locale.'/bookmarks');
                $this->assertTrue($client->getResponse()->isRedirect());
                $this->assertEquals(
                    '/'.$locale.'/login',
                    $client->getResponse()->getTargetUrl(),
                    sprintf('The (%s) bookmarks page secured URI redirects to the login form.', $locale)
                );
                // Check that trying to add bookmark from an article page for anonymous triggers 401 status code.
                // This status code will lead to display the login page (redirection from client using jQuery).
                $crawler = $client->request('GET', '/'.$locale.'/restaurants/le-temps-des-vendanges-france-toulouse');
                $this->addOrRemoveBookmarkFromArticlePage($crawler, $locale, $client);
                $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
            } else {
                // Test one restaurant.
                $this->playCompleteBookmarkWorkFlowForAnArticle(
                    $client,
                    $locale,
                    '/restaurants/le-temps-des-vendanges-france-toulouse',
                    'restaurant'
                );

                // Test one winemaker.
                $this->playCompleteBookmarkWorkFlowForAnArticle(
                    $client,
                    $locale,
                    '/winemakers/didier-barral',
                    'restaurant'
                );

                // Test one shop (other than a restaurant-shop)
                $this->playCompleteBookmarkWorkFlowForAnArticle(
                    $client,
                    $locale,
                    '/shops/le-tire-bouchon-france-abbaretz',
                    'shop'
                );
            }
        }
    }

    /**
     * Play complete bookmark workflow for an article.
     * Add a bookmark and remove it from article page.
     * Add a bookmark and remove it from bookmarks page.
     *
     * @param Symfony\Component\BrowserKit\Client $client
     * @param string                              $locale
     * @param string                              $articlePath The path to article without locale ('/restaurants/le-temps-des-vendanges-france-toulouse').
     */
    public function playCompleteBookmarkWorkFlowForAnArticle($client, $locale, $articlePath)
    {
        // Add a bookmark and remove it from article page.
        //
        // Check that on bookmarks page there are no bookmarks.
        $crawler = $client->request('GET', '/'.$locale.'/bookmarks');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->checkThatOnBookmarksPageThereAreNobookmarks($crawler, $locale);
        //
        // Add an article to bookmarks.
        $crawler = $client->request('GET', '/'.$locale.$articlePath);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->addOrRemoveBookmarkFromArticlePage($crawler, $locale, $client);
        $this->assertTrue($client->getResponse()->isSuccessful());
        //
        // Check that on article page the bookmark id has been created.
        $crawler = $client->request('GET', '/'.$locale.$articlePath);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $bookmarkId = $this->checkThatOnArticlePageTheBookmarkIdHasBeenCreated($crawler, $locale);
        //
        // Check that on bookmark page there is the expected bookmark.
        $crawler = $client->request('GET', '/'.$locale.'/bookmarks');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->checkThatOnBookmarksPageThereIsTheExpectedBoomark($crawler, $locale, $bookmarkId);
        //
        // Remove article from bookmarks from article page.
        $crawler = $client->request('GET', '/'.$locale.$articlePath);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->addOrRemoveBookmarkFromArticlePage($crawler, $locale, $client);
        $this->assertTrue($client->getResponse()->isSuccessful());
        //
        // Check that on article page the bookmark id has been deleted.
        $crawler = $client->request('GET', '/'.$locale.$articlePath);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->checkThatOnArticlePageTheBookmarkIdHasBeenDeleted($crawler, $locale);
        //
        // Check that on bookmarks page there are no bookmarks.
        $crawler = $client->request('GET', '/'.$locale.'/bookmarks');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->checkThatOnBookmarksPageThereAreNobookmarks($crawler, $locale);

        // Add a bookmark and remove it from bookmarks page.
        //
        // Add an article to bookmarks.
        $crawler = $client->request('GET', '/'.$locale.$articlePath);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->addOrRemoveBookmarkFromArticlePage($crawler, $locale, $client);
        $this->assertTrue($client->getResponse()->isSuccessful());
        //
        // Check that on article page the bookmark id has been created.
        $crawler = $client->request('GET', '/'.$locale.$articlePath);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $bookmarkId = $this->checkThatOnArticlePageTheBookmarkIdHasBeenCreated($crawler, $locale);
        // Check that on bookmark page there is the expected bookmark.
        //
        $crawler = $client->request('GET', '/'.$locale.'/bookmarks');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->checkThatOnBookmarksPageThereIsTheExpectedBoomark($crawler, $locale, $bookmarkId);
        // Remove restaurant from bookmarks from bookmarks page.
        $crawler = $client->request('GET', '/'.$locale.'/bookmarks');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->removeBookmarkFromBookmarkPage($crawler, $locale, $client, $bookmarkId);
        $this->assertTrue($client->getResponse()->isSuccessful());
        //
        // Check that on bookmarks page there are no bookmarks.
        $crawler = $client->request('GET', '/'.$locale.'/bookmarks');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->checkThatOnBookmarksPageThereAreNobookmarks($crawler, $locale);
        //
        // Check that on article page the bookmark id has been deleted.
        $crawler = $client->request('GET', '/'.$locale.$articlePath);
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->checkThatOnArticlePageTheBookmarkIdHasBeenDeleted($crawler, $locale);
    }

    /**
     * Add or remove bookmark from a bookmarkable article page (restaurant, winemaker, shop).
     * Fake AJAX and add authenticity token in header request.
     *
     * @param Symfony\Component\DomCrawler\Crawler $crawler
     * @param string                               $locale
     * @param Symfony\Component\BrowserKit\Client  $client
     */
    private function addOrRemoveBookmarkFromArticlePage($crawler, $locale, $client)
    {
        $bookmarkEntity = $crawler->filter('button[id="bookmark"]')->attr('data-bookmark-entity');
        $bookmarkEntityId = $crawler->filter('button[id="bookmark"]')->attr('data-bookmark-entity-id');
        $bookmarkAction = $crawler->filter('button[id="bookmark"]')->attr('data-bookmark-action');
        $bookmarkId = $crawler->filter('button[id="bookmark"]')->attr('data-bookmark-id');
        $authenticityCSRFToken = $crawler->filter('meta[name="authenticityCSRFToken"]')->attr('content');

        // Transmit data to bookmarkManager (as done by AJAX)
        $postDatas = array(
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
            'bookmarkEntity' => $bookmarkEntity,
            'bookmarkEntityId' => $bookmarkEntityId,
        );

        $crawler = $client->request(
            'POST',
            '/'.$locale.'/bookmarks/manage',
            $postDatas,
            array(),
            array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'HTTP_X_Csrf_token' => $authenticityCSRFToken,
                )
        );
    }

    /**
     * Remove bookmark from bookmarks page.
     * Fake AJAX and add authenticity token in header request.
     *
     * @param Symfony\Component\DomCrawler\Crawler $crawler
     * @param string                               $locale
     * @param Symfony\Component\BrowserKit\Client  $client
     * @param int                                  $bookmarkId
     */
    private function removeBookmarkFromBookmarkPage($crawler, $locale, $client, $bookmarkId)
    {
        $bookmarkAction = 'remove_only';
        $authenticityCSRFToken = $crawler->filter('meta[name="authenticityCSRFToken"]')->attr('content');

        // Transmit data to bookmarkManager (as done by AJAX)
        $postDatas = array(
            'bookmarkAction' => $bookmarkAction,
            'bookmarkId' => $bookmarkId,
        );

        $crawler = $client->request(
            'POST',
            '/'.$locale.'/bookmarks/manage',
            $postDatas,
            array(),
            array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'HTTP_X_Csrf_token' => $authenticityCSRFToken,
                )
        );
    }

    /**
     * Check that on bookmarks page there are no bookmarks.
     *
     * @param Symfony\Component\DomCrawler\Crawler $crawler
     * @param string                               $locale
     */
    private function checkThatOnBookmarksPageThereAreNobookmarks($crawler, $locale)
    {
        $this->assertEquals(
            '[]',
            $crawler->filter('#bookmarks')->attr('data-bookmark-ids'),
            sprintf('No bookmarks for (%s) page', $locale)
        );
        $this->assertEquals(
            0,
            $crawler->filter('.restaurants')->count(),
            sprintf('No bookmarks for (%s) page', $locale)
        );
        $this->assertEquals(
            0,
            $crawler->filter('.winemakers')->count(),
            sprintf('No bookmarks for (%s) page', $locale)
        );
        $this->assertEquals(
            0,
            $crawler->filter('.shops')->count(),
            sprintf('No bookmarks for (%s) page', $locale)
        );
    }

    /**
     * Check that on article page there is a bookmark id.
     *
     * @param Symfony\Component\DomCrawler\Crawler $crawler
     * @param string                               $locale
     *
     * @return int
     */
    private function checkThatOnArticlePageTheBookmarkIdHasBeenCreated($crawler, $locale)
    {
        $bookmarkId = $crawler->filter('button[id="bookmark"]')->attr('data-bookmark-id');
        $this->assertGreaterThan(
            0,
            $bookmarkId,
            sprintf('The (%s) bookmark has been created', $locale)
        );

        return $bookmarkId;
    }

    /**
     * Check that on bookmark pag there is the expected bookmark.
     *
     * @param Symfony\Component\DomCrawler\Crawler $crawler
     * @param string                               $locale
     * @param int                                  $bookmarkId
     */
    private function checkThatOnBookmarksPageThereIsTheExpectedBoomark($crawler, $locale, $bookmarkId)
    {
        $this->assertEquals(
            1,
            $crawler->filter('div[id="bookmark-'.$bookmarkId.'"]')->count(),
            sprintf('There is the expect bookmark on the (%s) bookmarks page', $locale)
        );
    }

    /**
     * Check that on article page the bookmark has been deleted.
     *
     * @param Symfony\Component\DomCrawler\Crawler $crawler
     * @param string                               $locale
     */
    private function checkThatOnArticlePageTheBookmarkIdHasBeenDeleted($crawler, $locale)
    {
        $bookmarkId = $crawler->filter('button[id="bookmark"]')->attr('data-bookmark-id');
        $this->assertEquals(
            '',
            $bookmarkId,
            sprintf('The (%s) article bookmark has been deleted', $locale)
        );
    }

    /**
     * Log user if not anonymous and get client.
     *
     * @param string $user
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    private function getClientForUser($user, $password)
    {
        if (null === $password) {
            return static::createClient();
        }

        return static::createClient([], [
            'PHP_AUTH_USER' => $user,
            'PHP_AUTH_PW' => $password,
        ]);
    }

    /**
     * Users providers.
     *
     * @return array array of [user, password and role].
     */
    public function usersProvider()
    {
        return  array(
            array('anonymous', null, 'IS_AUTHENTICATED_ANONYMOUSLY'),
            array('user', 'user', 'ROLE_USER'),
            array('author', 'author', 'ROLE_AUTHOR'),
            array('admin', 'admin', 'ROLE_ADMIN'),
        );
    }
}
