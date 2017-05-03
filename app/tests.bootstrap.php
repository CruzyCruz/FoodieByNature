<?php

require __DIR__.'/bootstrap.php.cache';
require_once __DIR__ . '/AppKernel.php';

$kernel = new AppKernel('test', true);
$kernel->boot();
$databases = array();
try {
    $connection = $kernel->getContainer()->get('database_connection');
    $sm = $connection->getSchemaManager();
    $databases = $sm->listDatabases();
} catch (\Exception $e) {
}
$dbname = $kernel->getContainer()->getParameter('database_name_test');

passthru(sprintf(
    'php "%s/console" cache:clear --env=%s --no-warmup',
    __DIR__,
    'test'
));
if (in_array($dbname, $databases)) {
    passthru(sprintf(
    'php "%s/console" doctrine:database:drop --force --env=%s ',
    __DIR__,
    'test'
    ));
}
passthru(sprintf(
'php "%s/console" doctrine:database:create --env=%s ',
__DIR__,
'test'
));
passthru(sprintf(
    'php "%s/console" doctrine:schema:create --env=%s',
    __DIR__,
    'test'
));
passthru(sprintf(
    'php "%s/console" doctrine:fixtures:load --env=%s --no-interaction',
    __DIR__,
    'test'
));
