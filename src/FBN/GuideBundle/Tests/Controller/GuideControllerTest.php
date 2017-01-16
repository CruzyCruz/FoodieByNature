<?php

namespace FBN\GuideBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional test for the controllers defined inside GuideController.
 *
 */
class GuideControllerTest extends WebTestCase
{
    /**
     * Application locales.
     *
     * @var array locales.
     */
    private static $locales = array('en', 'fr',);

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

    private static $rolesHierarchy = array(
        'IS_AUTHENTICATED_ANONYMOUSLY',
        'ROLE_USER',
        'ROLE_AUTHOR',
        'ROLE_ADMIN',
        );

    /**
     * @dataProvider usersProvider
     *
     * Test all links on homepage versus the different possible kind of user.
     * Nota : some links could only be available in homepage template for certains user (i.e "admin" for author and admin users).
     *
     */
    public function testHomeLinks($user, $password, $role)
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
     * Log user if not anonymous and get client.
     *
     * @param  string $user
     * @param  string $password
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
