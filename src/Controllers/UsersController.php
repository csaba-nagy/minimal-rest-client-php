<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Controllers;

use App\MinimalRestClientPhp\Enums\HttpStatusCodes;
use App\MinimalRestClientPhp\Http\Request;

final class UsersController extends Controller {

  public function index(): string {
    return $this->response(HttpStatusCodes::OK, 'Users Main Page');
  }

  public function show(Request $request): string {
    $result = "#{$request->getParams()['param']} User";

    return $this->response(HttpStatusCodes::OK, $result);
  }
}
