Foodie By Nature
================

This repository is a personnal training project to learn the Symfony framework and its ecosystem (Doctrine, Bundles, PHPUnit, Composer, Git...). It is also the basis of a website dedicated to natural wines :

 * find and review about places where you can eat and drink great natural wines
 * learn about natural winemakers
 * find shops
 * be aware of events
 * read tutorials

Come on and make a great website for all natural wines lovers!

Developed with love when I have time. For us, by us.

### PHP

 * **Version**

 `PHP >= 5.6` is required.

 * **Extensions**

`Intl` extension is required.

### Installation

** Note : The actual Symfony version is 2.8.x. There are still some deprecated lines of code to be modified before it is possible to upgrade to 3.x versions.**

 * **Clone the repository**

`git clone https://github.com/CruzyCruz/FoodieByNature`

 * **Install dependencies**

Browse to */path/to/FoodieByNature* and run

 `composer update`

*Note :* the `composer.lock` file is only used to keep dependencies version history.

When running this command, you will get the following error:

>Package egeloen/http-adapter is abandoned, you should avoid using it. Use php-http/httplug instead

This is because the package [`willdurand/geocoder-bundle 4.x`](https://github.com/geocoder-php/BazingaGeocoderBundle/blob/master/composer.json) uses [`willdurand/geocoder 3.x`](https://github.com/geocoder-php/Geocoder/tree/3.x) that uses [`egeloen/http-adapter`](https://github.com/egeloen/ivory-http-adapter) which is deprecated. This will be solved with the next major version of `willdurand/geocoder`. At this time time it is not really a problem as you can read [here](https://github.com/geocoder-php/Geocoder/issues/548#issuecomment-276022571).

* **Create parameters file**

Copy *app/config/parameters.yml.dist* content in *app/config/parameters.yml* (generated by composer during dependencies installation).

* **Configure database**

This configuration is for a MySQL databe but configure it to match your needs. See [here](http://symfony.com/doc/current/doctrine.html#configuring-the-database) for official documentation.

```yml
parameters:
    database_driver: pdo_mysql
    database_host: 127.0.0.1
    database_port: null
    database_name: fbn
    database_name_test: fbn_test
    database_user: your_database_username
    database_password: your_database_password
```

* **Configure swiftmailer**

This configuration is for a Gmail account but configure it to match your needs. See [here](http://symfony.com/doc/current/reference/configuration/swiftmailer.html) for official documentation.

```yml
parameters:
    mailer_transport: gmail
    mailer_host: 127.0.0.1
    mailer_user: your_username@gmail.com
    mailer_password: your_gmail_password
```

* **Configure the default locale**

By default, the main locale is `en`. That means, at backend level, that you can not translate your content until your have completed and validated your data for this locale. You can change it if you want. At this time two locales are used : `en` and `fr`.

```yml
parameters:
    locale: en
```

* **Choose a secret key**

This is needed for CSRF tokens generation, cookies encryption and signed URIS when using ESI. See [here](http://symfony.com/doc/current/reference/configuration/framework.html#secret) for official documentation.

```yml
parameters:
    secret: secret_string
```

* **Configure Oauth account**

The application permits to users to authenticate using Google and Facebook Oauth authentication. For that you need to enter your credentials at application level (see below) and configure the application in Google and Facebook developers consoles. See [here](https://github.com/hwi/HWIOAuthBundle/blob/0.4/Resources/doc/2-configuring_resource_owners.md) for official documentation.

```yml
parameters:
    google_client_id: google_client_id
    google_client_secret: google_client_secret
    fb_client_id: fb_client_id
    fb_client_secret: fb_client_secret
```    

In the Google and Facebook developper console enter the following authorized redirection URIs in your application (dev mode):

**Google**
`http://yourdomain/app_dev.php/fr/login/check-google`
`http://yourdomain/app_dev.php/en/login/check-google`

**Facebook**
`http://yourdomain/app_dev.php/fr/login/check-facebook`
`http://yourdomain/app_dev.php/en/login/check-facebook`

### Database

 * **Create database**

 `php app/console doctrine:database:create`

 * **Create schema**

 `php app/console doctrine:schema:create`

 * **Load fixtures**

 `php app/console doctrine:fixtures:load`

 This can take a little moment (10/20 seconds) as Geocoding is used to fetch some coordinates (longitude, latitude).

 * **Schema (UML)**

You can have an overview of the database schema using [Dia](http://dia-installer.de/index.html). The schema is located in:

`src/FBN/GuideBundle/Resources/doc/fbn.dia`

### Tests

* **Install PHPUnit**

See [here](https://phpunit.de/manual/current/en/installation.html#installation.phar) for official documentation.

* **Run tests**

Browse to */path/to/FoodieByNature* and run

`phpunit -c app`

*Note :* Each time you run the tests, cache is cleared and the test database is deleted and re-created (or only created the first time) to reflect the last database schema. Then fixtures are loaded. This is enough for now, but, it should be repeated before some tests in the future. In this case, sqlite database (using file copy to get a fresh database) could be used.

### Usage

See [here](http://symfony.com/doc/current/setup/web_server_configuration.html) to learn about server configuration.

* **Public website**

Homepage (dev mode) is accessible from the following URIs:

`http://yourdomain/app_dev.php/en/`
`http://yourdomain/app_dev.php/fr/`

* **Admin panel**

Admin panel (dev mode) is accessible from the following URIs:

`http://yourdomain/app_dev.php/en/admin`
`http://yourdomain/app_dev.php/fr/admin`

### About templates

They s**k and are coded with my feet. At this time they only permit to have something to display.

### Contributing

Everybody is very welcome. Only one general philosophy : be cool!

**Contribute to code**

 * Propose constructive comments.
 * Propose code improvements.

**Contribute to website**

 * Propose new functionnalities.

**Others** 

 * Drink natural wine.
 * Take the apéro.

### To be done

 * Install FOSUserBundle 2.0 and make the necessary modifications (using the new event RESETTING_SEND_EMAIL_COMPLETED)
 * Remove deprecated Symfony code (actual SF version : 2.8.x).
 * Add more tests.
 * Add CI with Travis.
 * Add more code coments (PHPDoc blocks).
 * Add permissions depending on user role.
 * Simplify adress system using geocoding.
 * Add search functionnality : Elastic Search.
 * Add contact form.
 * Add pagination : loading by AJAX ?
 * Add article social sharing links.
 * Add newsletter.
 * Add RSS.
 * Manage caching.
 * Add design : Bootstrap ?
 * Push site to production : Heroku ?

### License

This software is published under the MIT License.
