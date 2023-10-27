<?php

declare(strict_types=1);
namespace Idos\Http;

use Exception;
use Idos\Request;

class HttpRequest
{
    public string $requestMethod;

    public string $requestUri;

    public function __construct() {
        $this->requestMethod = Request::getRequestMethod();
        $this->requestUri = Request::getRequestUri();
    }

    /**
     * @throws Exception
     */
    public function getInput(string $key): mixed {
        if (! isset($_POST[$key])) {
            throw new Exception(sprintf("Undefined key `%s`", $key));
        }
        return $_POST[$key];
    }
}