<?php

declare(strict_types=1);

namespace Idos;

use Exception;
use Idos\Controllers\BaseController;

class ControllerLoader
{
    private const CONTROLLERS_FOLDER = __DIR__ . "/Controllers";

    public function __construct(
        private readonly string $controllerName,
        private readonly string $methodName,
        private readonly array  $params
    ) {}

    /**
     * @throws Exception
     */
    public function loadController(): void {
        $ctrlFile = self::CONTROLLERS_FOLDER . "/" . $this->controllerName . "Controller.php";
        if (! is_file($ctrlFile)) {
            throw new Exception(sprintf("Controller `%s` not found", $ctrlFile));
        }

        $controller = "\\Idos\\Controllers\\{$this->controllerName}Controller";
        $controller = new $controller();
        $controller->{$this->methodName}(...$this->params);
    }
}