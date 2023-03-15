<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Controllers;

final class IndexController extends Controller
{
    public function index(): string {
      return 'Main Page';
    }
}
