<?php
chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';
$app       = $container->get(Zend\Expressive\Application::class);

$app->run();
