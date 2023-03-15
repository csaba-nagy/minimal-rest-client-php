<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Controllers;

use App\MinimalRestClientPhp\Http\Request;

final class UsersController extends Controller {

  public function index(): string {
    return 'Users Index page';
  }

  public function show(Request $request): string {
    $result = "#{$request->getParams()['param']} User";

    return $this->response(200, $result);
  }
}
