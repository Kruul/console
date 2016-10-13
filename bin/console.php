#!/opt/php7/bin/php
<?php
use Symfony\Component\Console\Application;

chdir(dirname(__DIR__));
require __DIR__.'/../vendor/autoload.php';

$container = require 'config/console.container.php';
$app=$container['console.application'];
$app->run();
