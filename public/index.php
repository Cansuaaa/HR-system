<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

use Yee\Managers\DatabaseManager;
use Yee\Managers\RoutingCacheManager;
use Yee\Yee;

session_start();

error_reporting( E_ALL );

// Instantiate the app
$config = require __DIR__ . '/../config.php';
$app = new Yee($config);
$app->setName('hrsystem');
$app->view( new \Yee\Views\Twig());

$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => __DIR__ . '/../cache/templates_c',
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);

$app->view->parserExtensions = array(new \Yee\Views\TwigExtension());

/* we need the session variable exposed within templates */
$twig = $app->view()->getEnvironment();

$twig->addGlobal('session', $_SESSION);
//$twig->addExtension(new Twig_Extensions_Extension_Text());
//$twig->addExtension(new Twig_Extensions_Extension_I18n(putenv('LC_ALL=fr_FR'),
//setlocale(LC_ALL, 'fr_FR')));

$app->container->set("mailer", function() { return new \App\Library\Mailer(); });

new DatabaseManager();

new RoutingCacheManager(
    array(
        'cache' => __DIR__ . '/../cache/routing',
        'controller' => array( __DIR__ . '/../App/Controllers' )
    )
);
$app->container->set('differentLanguages',new \App\Models\AddNewWordInLanguagesModel());
$model = new App\Models\AddNewWordInLanguagesModel();
if (isset($_COOKIE['language'])) {
    $_SESSION['language'] = $model->getData($_COOKIE['language']);
} else {
    $_SESSION['language'] = $model->getData('en');
}

// Run app
$app->execute();

