<?php

declare(strict_types=1);

namespace Idos\Database;

use IteratorAggregate;
use PDO;
use PDOStatement;
use Traversable;

class Result implements IteratorAggregate
{
    private int $columnCount;

    public function __construct(
        private readonly PDOStatement $stmt,
        private readonly string|int|null $lastInsertId,
        private readonly int $rowCount,
    ) {
        $this->columnCount = $this->stmt->columnCount();
    }

    public function getIterator(): Traversable
    {
        return $this->stmt->getIterator();
    }

    public function fetchRow(): ?array
    {
        $row = $this->stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return $row;
    }

    public function fetchColumn(int $column = 0): mixed
    {
        $value = $this->stmt->fetchColumn($column);

        if ($value === false) {
            return null;
        }

        return $value;
    }

    public function hasResult(): bool
    {
        return $this->columnCount > 0;
    }

    public function getLastInsertId(): int|string|null
    {
        return $this->lastInsertId;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public static function fromStatement(PDOStatement $stmt, string|int|null $lastInsertId): self
    {
        $rowCount = $stmt->rowCount();
        return new self($stmt, $lastInsertId, $rowCount);
    }
}
