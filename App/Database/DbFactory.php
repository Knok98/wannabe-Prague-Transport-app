<?php

declare(strict_types=1);

namespace Idos\Database;

use PDO;

class DbFactory
{
    public function __construct(
        private readonly string $host,
        private readonly string $username,
        #[\SensitiveParameter]
        private readonly string $password,
        private readonly string $database,
        private readonly string $charset,
    ) {
    }

    public function create(): Db
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            rawurlencode($this->host),
            rawurlencode($this->database),
            rawurlencode($this->charset),
        );

        $pdo = new PDO(
            $dsn,
            $this->username,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );

        return new Db($pdo);
    }
}
