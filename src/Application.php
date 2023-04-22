<?php

namespace App\MinimalRestClientPhp;

use App\MinimalRestClientPhp\Http\Router;

class Application
{
  public function __construct(private Router $router)
  {}

  public function main()
  {
    return $this->router->resolve();
  }
}
