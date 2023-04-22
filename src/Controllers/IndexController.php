<?php

declare(strict_types=1);

namespace App\MinimalRestClientPhp\Controllers;

use App\MinimalRestClientPhp\Enums\HttpStatusCodes;

final class IndexController extends Controller
{
    public function index(): string {
      return $this->response(HttpStatusCodes::OK, 'Main Page');
    }
}
