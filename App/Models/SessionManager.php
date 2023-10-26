<?php

declare(strict_types=1);
namespace Idos\Models;

use Exception;

class SessionManager
{
    public function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    /**
     * @throws Exception
     */
    public function get(string $key): mixed {
        if (!isset($_SESSION[$key])) {
            throw new Exception(sprintf("Undefined key `%s`", $key));
        }
        return $_SESSION[$key];
    }
}