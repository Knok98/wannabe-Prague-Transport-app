<?php

namespace Idos\Routing;

class Route
{
    public function __construct(
        public readonly string $urlPattern,
        public readonly string $controller,
        public readonly string $action,
        public readonly array $httpMethods = [Router::METHOD_GET]
    ) {
    }
}