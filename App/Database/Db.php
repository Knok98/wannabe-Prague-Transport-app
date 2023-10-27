<?php

declare(strict_types=1);

namespace Idos\Database;

use Idos\Database\Exception\DbException;
use PDO;
use PDOException;

class Db
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    public function select(string $table): Builder\Select
    {
        return new Builder\Select($this, $table);
    }

    public function insert(string $table): Builder\Insert
    {
        return new Builder\Insert($this, $table);
    }

    public function update(string $table, array $params = []): Builder\Update
    {
        return new Builder\Update($this, $table, $params);
    }

    public function delete(string $table): Builder\Delete
    {
        return new Builder\Delete($this, $table);
    }

    /**
     * @throws DbException
     */
    public function executeQuery(Query $query): Result
    {
        return $this->execute($query->getQueryString(), $query->getParams());
    }

    /**
     * @throws DbException
     */
    public function execute(string $queryString, array $params = []): Result
    {
        try {
            $stmt = $this->pdo->prepare($queryString);
            $stmt->execute($params);
        } catch (PDOException $e) {
            throw new DbException($e->getMessage(), $queryString, $e->getCode(), $e);
        }

        $lastInsertId = null;
        try {
            $lastInsertId = $this->pdo->lastInsertId();
        } catch (PDOException) {
            // Ignore it, just not set $lastInsertId
        }
        if ($lastInsertId === false) {
            $lastInsertId = null;
        }

        return Result::fromStatement($stmt, $lastInsertId);
    }
}
