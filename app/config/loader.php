<?php

// $config = $this->getConfig();
$config = $this->config;

$loader = new \Phalcon\Loader();
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
);
$loader->register();
