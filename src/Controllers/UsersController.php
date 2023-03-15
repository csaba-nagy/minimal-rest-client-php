<?php

// declare(strict_type=1);

namespace App\MinimalRestClientPhp\Controllers;

final class UsersController extends Controller {

  public function index(): string {
    return 'Users Index page';
  }

  public function show(string $id): string {
    return "#{$id} User";
  }
}
