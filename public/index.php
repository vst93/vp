<?php
require_once '../vendor/autoload.php';

define('ROOT',__DIR__.'/../');

require_once '../v/core/Controller.php';
require_once('../v/core/App.php');

$app = new core\App();
$app->run();


