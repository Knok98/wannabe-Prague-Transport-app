<?php

declare(strict_types=1);

namespace Idos\Routing;

class RouteFactory
{
    public static function create(): RouteSet
    {
        // zde se registrují nové routy
        return new RouteSet([
            new Route('/', 'Home', 'index'),
        ]);
    }
}