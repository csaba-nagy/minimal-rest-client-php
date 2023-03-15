<?php

declare(strict_types=1);

require_once './vendor/autoload.php';

use App\MinimalRestClientPhp\Http\Request;
use App\MinimalRestClientPhp\Http\Router;

try {
  $router = new Router(new Request());

  var_dump($router->resolve());
} catch (\Exception $err) {
  var_dump($err->getMessage());
}
