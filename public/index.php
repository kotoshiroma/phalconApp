<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Http\Response;

error_reporting(E_ALL);
$debug = new \Phalcon\Debug();
$debug->listen();

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

$loader = new Loader();
$loader->registerDirs(
    [
        APP_PATH.'/controllers',
        APP_PATH.'/models',
        APP_PATH.'/forms',
    ]
);
$loader->register();


$di = new FactoryDefault();

try {

    // $config = $di->getConfig;
    // include APP_PATH . '/config/loader.php';
    
    include APP_PATH . '/config/router.php';
    include APP_PATH . '/config/services.php';

    $application = new Application($di);
    $response = $application->handle();
    $response->send();

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
