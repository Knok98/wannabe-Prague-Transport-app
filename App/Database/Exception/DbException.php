<?php

declare(strict_types=1);

namespace Idos\Database\Exception;

use Exception;
use Throwable;

class DbException extends Exception
{
    protected string|int $pdoCode;
    protected string $sql;

    public function __construct(string $message, string $sql, int|string $pdoCode, ?Throwable $previous = null)
    {
        parent::__construct($message, (int)$pdoCode, $previous);
        $this->pdoCode = $pdoCode;
        $this->sql = $sql;
    }

    public function getPdoCode(): int|string
    {
        return $this->pdoCode;
    }

    public function getSql(): string
    {
        return $this->sql;
    }
}
