<?php

declare(strict_types=1);
namespace Idos\Http;

use Exception;

class HttpRequest
{
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