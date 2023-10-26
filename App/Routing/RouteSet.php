<?php

namespace Idos\Routing;

use Traversable;

class RouteSet implements \IteratorAggregate
{

    /**
     * @param Route[] $routes
     */
    public function __construct(
        private readonly array $routes
    ) {
    }
    public function getIterator(): Traversable
    {
        yield from $this->routes;
    }
}