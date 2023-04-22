<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\MinimalRestClientPhp\Container;
use App\MinimalRestClientPhp\Application;

try {
  $container = new Container();
  $app = $container->get(Application::class);

  var_dump($app->main());
} catch (\Exception $error) {
  var_dump($error->getMessage());
}
