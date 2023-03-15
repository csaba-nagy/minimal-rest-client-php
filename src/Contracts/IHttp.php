<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Contracts;

interface IHttp {
  public function index(): string;

  public function show(string $id): string;

  public function read(?string $id): string;

  public function store();

  public function update();

  public function destroy();
}
