<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\Application;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Http\Response;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH.'/controllers',
        APP_PATH.'/models',
    ]
);

$loader->register();

$di = new FactoryDefault();
$di->set(
    'view',
    function() {
        $view = new View();
        $view->setViewDir(APP_PATH.'/views/');
        return $view;
    }
);

// $url = new Url();
// echo "ベースURI：".$url->getBaseUri()."<br>";
// $url->setBaseUri('/');
// echo "ベースURI_mod：".$url->getBaseUri();

$di->set(
    'url',
    function() {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);


// $di->set(
//     "db",
//     function () {
//         // return new DbAdapter(
//         //     [
//         //         "host"     => "localhost",
//         //         "username" => "phalconuser",
//         //         "password" => "phalconuser",
//         //         "dbname"   => "phalcon_db",
//         //     ]
//         // );
//         return new DbAdapter(array
//             (
//                 "host"     => "localhost",
//                 "username" => "phalconuser",
//                 "password" => "phalconuser",
//                 "dbname"   => "phalcon_db",
//             )
//         );
//     }
// );

try {

    include APP_PATH . '/config/router.php';

    include APP_PATH . '/config/services.php';

    $config = $di->getConfig();

    include APP_PATH . '/config/loader.php';

    $application = new Application($di);

    $response = $application->handle();
    // $application->handle();
    // $response = new Response();
    // $response->setStatusCode(404, "Not Found");
    // $response->setContent("Sorry, the page doesn't exist");
    $response->send();

    // echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent()); 自動生成されたコード

} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
