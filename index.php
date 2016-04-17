<?php

/* Global framework */
require 'ext/slim/Slim/Slim.php';
require 'ext/underscore-php/underscore.php';
require 'core/fdate.php';

require_once 'core/utils.php';
require_once 'core/query.php';
require_once 'core/models/post.php';
require_once 'core/collections/posts.php';

/* To remove in prod */
error_reporting(E_ALL & ~E_STRICT);

/* Const */
define('ROOT_PATH', 'http://fizzy.local/');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/* To remove in prod */
$app->config('debug', true);

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

/* Slim App Delegator */
$delegator = array(
    'app' => $app,
    'deps' => $deps
);

/* home */
$app->get('/', function () use ($delegator) {
    $app = $delegator['app'];
    $deps = $delegator['deps'];

    $deps = Utils::getAllDeps($deps, 'home');

    $require = $deps['require'];

    $app->render('/header.php', array(
        'title' => 'Hello',
        'css' => $require['css']
    ));

    $app->render('/home.php');

    $app->render('/footer.php', array(
        'js' => $require['js'])
    );
})->name('home');

$app->map('/posts(/(:id))', function($id = null) use ($delegator) {
    $app = $delegator['app'];
    $deps = $delegator['deps'];

    $posts = new Posts();

    $conds = '';
    $values = array();

    if (!is_null($id)) {
        $conds = 'WHERE Id = :id';

        $values = array('id' => $id);
    }

    $posts->fetch($conds, $values);

    echo $posts->toJson();
})->via('GET', 'POST')->name('posts');

$getAsset = function($route) use ($delegator) {
    $app = $delegator['app'];

    /* Check if not asking for an asset file */
    $params = $route->getParams();
    $asset = implode('/', array_pop($params));
    
    if (file_exists($path)) {
        $app->halt(200, file_get_contents($path));
    } else {
        $app->pass();
    }
};

$unknownRoute = function($unk) use ($delegator) {
    $app = $delegator['app'];
    $deps = $delegator['deps'];

    $deps = __::find($deps, function($dep) {
        return $dep['name'] === 'defaults';
    });

    $require = $deps['require'];

    $app->render('/header.php', array(
        'title' => 'Not found',
        'css' => $require['css']
    ));

    $app->render('404.php', array(
        'page' => implode('/', $unk)
    ));

    $app->render('/footer.php', array(
        'js' => $require['js']
    ));
};

/* Wildcard to catch 404.
 * Always the last route to declare */
$app->map('/:unk+', $getAsset, $unknownRoute)->via('GET')->name('unknown');

/* mandatory, do not overwrite */

$app->run();

?>