<?php

require(__DIR__.'/vendor/autoload.php');

use SsoSdk\SsoClient;

$client = new SsoClient();
$client->run();