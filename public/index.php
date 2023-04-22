<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\MinimalRestClientPhp\Container;
use App\MinimalRestClientPhp\Application;

try {
  $container = Container::getInstance();

  // The following line show that how an interface can be handled:
  // $container->set(IDemo::class,DemoClass::class);

  $app = $container->get(Application::class);

  var_dump($app->main());
} catch (\Exception $error) {
  var_dump($error->getMessage());
}
