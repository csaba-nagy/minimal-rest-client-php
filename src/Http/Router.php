<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Http;

use App\MinimalRestClientPhp\Contracts\HttpInterface;
use Exception;

final class Router
{
  private HttpInterface $controller;


  public function __construct(private Request $request)
  {
    $route = $this->request->getExplodedUri();

    $router = $route[0] ?? null;
    $param =  $route[1] ?? null;

    $this->controller = $this->createController(empty($router) ? 'index' : $router);

    if (empty($param)) {
      return;
    }

    $this->request->setParams(['param' => $param]);
  }

  public function resolve()
  {
    return $this->controller->{$this->request->getMethod()}($this->request);
  }

  private function createController(string $controllerName): HttpInterface
  {
    $controller = 'App\MinimalRestClientPhp\Controllers\\' . ucfirst($controllerName) . 'Controller';

    if (class_exists($controller)) {
      $class = new $controller();

      if (method_exists($class, $this->request->getMethod())) {
        return $class;
      }
    }

    throw new Exception('Invalid route or request method!');
  }
}
