<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Http;

use App\MinimalRestClientPhp\Enums\HttpStatusCodes;

class Response
{
  public function __construct(private HttpStatusCodes $statusCode, private array | string $responseBody)
  {
  }

  public function sendJSON(): string
  {
    http_response_code($this->statusCode->value);

    return json_encode($this->responseBody, JSON_PRETTY_PRINT);
  }
}
