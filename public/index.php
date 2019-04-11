<?php

require_once '../vendor/autoload.php';

include '../Application/config.php';

define ("URL","/StacArtem/public");

use Application\Controllers\ApplicationController;

$app = new ApplicationController();
$app->Start();


