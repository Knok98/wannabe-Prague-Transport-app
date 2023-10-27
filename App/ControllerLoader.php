<?php

declare(strict_types=1);

namespace Idos;

use Exception;
use Idos\Controllers\BaseController;
use Idos\Http\HttpRequest;

class ControllerLoader
{
    private const CONTROLLERS_FOLDER = __DIR__ . "/Controllers";

    private ?DIContainer $container = null;

    private HttpRequest $request;

    public function __construct(
        private readonly string $controllerName,
        private readonly string $methodName,
        private readonly array  $params
    ) {
        $this->request = new HttpRequest();
    }

    /**
     * @throws Exception
     */
    public function loadController(): void {
        $ctrlFile = self::CONTROLLERS_FOLDER . "/" . $this->controllerName . "Controller.php";
        if (! is_file($ctrlFile)) {
            throw new Exception(sprintf("Controller `%s` not found", $ctrlFile));
        }

        $controller = "\\Idos\\Controllers\\{$this->controllerName}Controller";
        $controller = new $controller(
            $this->container->getDb(),
            $this->container->getSessionManager()
        );

        $controller->{$this->methodName}($this->request, ...$this->params);
    }

    public function setContainer(DIContainer $container): void
    {
        $this->container = $container;
    }
}