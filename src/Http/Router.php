<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Http;

use App\MinimalRestClientPhp\Contracts\IHttp;
use Exception;

final class Router
{
  private IHttp $controller;


  public function __construct(private Request $request) {
    $route = $this->explodeRoute();

    $this->controller = $this->createController(empty($route[0]) ? 'index' : $route[0]);
    $param = $route[1] ?? null;

    if (!empty($param)) {
      $this->request->setParams(['param' => $param]);
    }
  }

  public function resolve() {
    return $this->controller->{$this->request->getMethod()}($this->request);
  }

  private function explodeRoute(): array {
    return explode('/', substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),1));
  }

  private function createController (string $controllerName): IHttp {
    $controller = 'App\MinimalRestClientPhp\Controllers\\' . ucfirst($controllerName) . 'Controller';

    if(!class_exists($controller)) {
      throw new Exception('Invalid Route');
    }

    return new $controller();
  }
}
