<?php

declare(strict_types=1);

namespace Idos;

use Idos\Routing\Route;

class Request
{
    public function __construct(
        public readonly string $controller,
        public readonly string $action,
        public readonly array $params,
        public readonly Route $route
    ) {}

    public static function getRequestUri(): string {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getRequestMethod(): string {
        return $_SERVER['REQUEST_METHOD'];
    }
}