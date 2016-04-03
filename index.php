<?php

/* Global framework */
require 'ext/slim/Slim/Slim.php';
require 'ext/underscore-php/underscore.php';
require 'core/fdate.php';

require_once 'core/query.php';

/* To remove in prod */
error_reporting(E_ALL & ~E_STRICT);

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$confName = 'etc/fizzy.cf';

if (!file_exists($confName)) {
    error_log('Cannot load dependencies configuration.');

    return;
} else {
    $cf = json_decode(file_get_contents($confName), true);

    if (is_null($cf)) {
        error_log('Conf JSON invalid.');

        return;
    }
}

/* Configure query tool */ 
$db = $cf['db'];
Query::define($db['dsn'], $db['username'], $db['password']);

/* Assets dependencies */
$deps = $cf['deps'];

$defaults = __::find($deps, function($dep) {
    return $dep['name'] === 'defaults';
});

/* Slim App Delegator */
$delegator = array(
    'app' => $app,
    'deps' => $deps,
    'defaults' => $defaults
);

/* home */
$app->get('/', function () use ($delegator) {
    $app = $delegator['app'];
    $deps = $delegator['deps'];
    $defaults = $delegator['defaults'];

    $localDeps = __::find($deps, function($dep) {
        return $dep['name'] === 'home';
    });

    $requires = $localDeps['require'];

    $app->render('/header.php', array(
        'title' => 'Home',
        'css' => $requires['css']
    ));

    $app->render('/home.php');

    $app->render('/footer.php', array(
        'js' => $requires['js'])
    );
})->name('home');

/* $app->get('/posts', function() use ($delegator) {
    $app = $delegator['app'];
    $files = $delegator['files'];

	$app->render('core/list.php', array(
		'db' => $delegator['db'],
		'collection' => 'stopovers',
		'parameters' => array()
	));
}); */

/* mandatory, do not overwrite */

$app->run();

?>