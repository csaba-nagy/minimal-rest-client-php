<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Contracts;

use App\MinimalRestClientPhp\Http\Request;

interface HttpInterface
{
  public function index(): string;

  public function show(Request $request): string;

  public function read(Request $request): string;

  public function store(Request $request);

  public function update(Request $request);

  public function destroy(Request $request);
}
