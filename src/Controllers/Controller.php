<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Controllers;

use App\MinimalRestClientPhp\Contracts\HttpInterface;
use App\MinimalRestClientPhp\Enums\HttpStatusCodes;
use App\MinimalRestClientPhp\Http\{ Request, Response };

use Exception;

abstract class Controller implements HttpInterface {

  abstract public function index(): string;

  public function read(Request $request): string {

    return isset($request->getParams()['param'])
      ? $this->show($request)
      : $this->index();
  }

  public function show(Request $request): string {
    throw new Exception('Not implemented!');
   }

  public function store(Request $request) {
    throw new Exception('Not implemented!');
   }

  public function update(Request $request) {
    throw new Exception('Not implemented!');
   }

  public function destroy(Request $request) {
    throw new Exception('Not implemented!');
   }

   protected function response(HttpStatusCodes $statusCode, array | string $body) {
    $response = new Response($statusCode, $body);

    return $response->sendJSON();
   }
}
