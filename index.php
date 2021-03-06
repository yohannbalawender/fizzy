<?php

/* Global framework */
require 'ext/slim/Slim/Slim.php';
require 'ext/underscore-php/underscore.php';
require 'core/fdate.php';

require_once 'core/utils.php';
require_once 'core/error.php';
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

/* Requests */
$app->group('/req', function () use ($delegator) {
    $app = $delegator['app'];

    /* Posts list */
    $app->map('/posts(/(:id))', function($id = null) use ($delegator) {
        $app = $delegator['app'];

        $posts = new Posts();

        $conds = '';
        $values = array();

        if (!is_null($id)) {
            $conds = 'WHERE Id = :id';

            $values = array('id' => $id);
        }

        $posts->fetch($conds, $values);

        $app->response->setStatus(200);
        $app->response->write($posts->toJson());
    })->via('GET', 'POST')->name('req-posts');

    /* Single post */
    $app->map('/post/:id', function ($id = null) use ($delegator) {
        $app = $delegator['app'];

        /* Currently useless */
        if ($id == null) {
            $error = new FError('Cannot get post with unknown id.');

            $app->response->setStatus(400);
            $app->response->write($error->getResponse('json'));
        }

        $post = new Post();

        $post->fetch($id);

        $app->response->setStatus(200);
        $app->response->write($post->toJson());
    })->via('GET', 'POST')->name('req-post');
});

/* Posts */
$app->group('/', function() use ($delegator) {
    $app = $delegator['app'];

    $app->get('', function () use ($delegator) {
        $app = $delegator['app'];
        $deps = $delegator['deps'];

        $deps = Utils::getAllDeps($deps, 'home');

        $require = $deps['require'];

        $app->render('/header.php', array(
            'title' => 'Hello',
            'css' => $require['css']
        ));

        $app->render('/footer.php', array(
            'js' => $require['js'])
        );
    })->name('home');

    $app->get('posts(/)', function () use ($delegator) {
        $app = $delegator['app'];
        $deps = $delegator['deps'];

        $deps = Utils::getAllDeps($deps, 'home');

        $require = $deps['require'];

        $app->render('/header.php', array(
            'title' => 'Hello',
            'css' => $require['css']
        ));

        $app->render('/footer.php', array(
            'js' => $require['js'])
        );
    })->name('home');
});

/* Default */
$getAsset = function($route) use ($delegator) {
    $app = $delegator['app'];

    /* Check if not asking for an asset file */
    $params = $route->getParams();
    $domain = $params['unk'][0];
    $asset = implode('/', array_pop($params));

    if ($domain === 'assets') {
        if (file_exists($asset)) {
            $app->halt(200, file_get_contents($asset));
        } else {
            $app->halt(404);
        }
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

$notFound = function() use ($delegator) {
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

    $app->render('404-unk.php');

    $app->render('/footer.php', array(
        'js' => $require['js']
    ));
};

/* Wildcard to catch 404.
 * Always the last route to declare */
$app->map(':unk+', $getAsset, $unknownRoute)->via('GET')->name('unknown');

$app->notFound($notFound);

/* mandatory, do not overwrite */

$app->run();

?>