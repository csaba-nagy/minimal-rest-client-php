<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Controllers;

use App\MinimalRestClientPhp\Contracts\IHttp;
use Exception;

class Controller implements IHttp {
  public function index(): string {
    throw new Exception('Not implemented!');
  }

  public function read(?string $id): string {
    return $id ? $this->show($id) : $this->index();
  }

  public function show(string $id): string {
    throw new Exception('Not implemented!');
   }

  public function store() {
    throw new Exception('Not implemented!');
   }

  public function update() {
    throw new Exception('Not implemented!');
   }

  public function destroy() {
    throw new Exception('Not implemented!');
   }
}
