<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Controllers;

use App\MinimalRestClientPhp\Contracts\IHttp;
use App\MinimalRestClientPhp\Enums\HttpStatusCodes;
use App\MinimalRestClientPhp\Http\Request;
use App\MinimalRestClientPhp\Http\Response;
use Exception;

class Controller implements IHttp {

  public function index(): string {
    throw new Exception('Not implemented!');
  }

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
