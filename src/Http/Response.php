<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Http;

class Response
{
  public function __construct(private int $statusCode, private array | string $responseBody)
  {
  }

  public function send(): string
  {
    http_response_code($this->statusCode);

    return json_encode($this->responseBody, JSON_PRETTY_PRINT);
  }
}
