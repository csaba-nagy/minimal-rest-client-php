<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use App\MinimalRestClientPhp\Http\Router;

try {
  $router = new Router();

  var_dump($router->resolve());
} catch (\Exception $err) {
  var_dump($err->getMessage());
}
