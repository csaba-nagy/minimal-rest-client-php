<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Http;

use App\MinimalRestClientPhp\Contracts\IHttp;
use Exception;

final class Router
{
  private string $requestMethod;
  private IHttp $controller;
  private ?string $param;

  public function __construct() {
    $this->requestMethod = match(strtolower($_SERVER['REQUEST_METHOD'])) {
      'get'     => 'read',
      'post'    => 'store',
      'patch'   => 'update',
      'delete'  => 'destroy',
      'default' => 'read'
    };

    $route = $this->explodeRoute();

    $this->controller = $this->createController(empty($route[0]) ? 'index' : $route[0]);
    $this->param = $route[1] ?? null;

  }

  public function resolve() {
    return $this->controller->{$this->requestMethod}($this->param);
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
