<?php

declare(strict_types=1);

namespace Idos;
use Exception;
use Idos\DIContainer;
use Idos\Routing\RouteFactory;
use Idos\Routing\Router;
use Idos\Routing\RouteSet;

class App
{
    private Router $router;

    public function __construct(
        private readonly DIContainer $container,
    ) {
        session_start();
        $this->router = new Router(RouteFactory::create());
    }

    /**
     * Zde probíhá bootování celé aplikace
     * @throws Exception
     */
    public function boot(): void {

        try {
            $request = $this->router->match(
                Request::getRequestUri(),
                Request::getRequestMethod()
            );

            $loader = new ControllerLoader($request->controller, $request->action, $request->params);
            $loader->loadController();

        } catch (Exception $e) {
            print $e->getMessage();
        }
    }
}