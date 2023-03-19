<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Http;

class Request
{
  private string $uri;
  private ?string $query;
  private string $method;
  private string $httpMethod;
  private ?array $payload;
  private array $params = [];

  public function __construct()
  {
    $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $this->query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

    $this->httpMethod = strtolower($_SERVER['REQUEST_METHOD']);

    $this->method = match($this->httpMethod) {
      'get'     => 'read',
      'post'    => 'store',
      'patch'   => 'update',
      'delete'  => 'destroy',
      'default' => 'read'
    };

    // TODO: add payload validation
    $this->payload = in_array($this->httpMethod, ['post', 'patch'])
      ? json_decode(file_get_contents('php://input'), true)
      : null;
  }

  public function getMethod(): string
  {
      return $this->method;
  }

  public function getUri(): string
  {
      return $this->uri;
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
    return explode('/', substr($this->uri,1));
  }

}
