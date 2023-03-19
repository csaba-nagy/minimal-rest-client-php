<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Http;

class Request
{
  private string $requestUri;
  private ?string $requestQuery;
  private string $method;
  private string $requestMethod;
  private ?array $payload;
  private array $params = [];

  public function __construct()
  {
    $this->requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $this->requestQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

    $this->requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

    $this->method = match($this->requestMethod) {
      'get'     => 'read',
      'post'    => 'store',
      'patch'   => 'update',
      'delete'  => 'destroy',
      'default' => 'read'
    };

    // TODO: add payload validation
    $this->payload = in_array($this->requestMethod, ['post', 'patch'])
      ? json_decode(file_get_contents('php://input'), true)
      : null;
  }

  public function getMethod(): string
  {
      return $this->method;
  }

  public function getRequestUri(): string
  {
      return $this->requestUri;
  }

  public function getPayload(): ?array
  {
      return $this->payload;
  }

  public function setParams(array $params)
  {
    $this->params = $params;
  }

  public function getParams(): array
  {
    return $this->params;
  }

  public function getExplodedUri() : array
  {
    return explode('/', substr($this->requestUri,1));
  }

}
