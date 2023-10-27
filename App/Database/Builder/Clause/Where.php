<?php

declare(strict_types=1);

namespace Idos\Database\Builder\Clause;

use Idos\Database\Exception\InvalidQueryException;
use Idos\Database\Helper;

trait Where
{
    /** @var string[] */
    private array $whereConditions = [];
    /** @var array<float|int|string> */
    private array $whereParams = [];

    public function where(string $expression, float|int|string|null ...$params): self
    {
        $this->whereConditions[] = $expression;
        $this->whereParams = array_merge($this->whereParams, array_values($params));
        return $this;
    }

    public function whereEq(string $column, float|int|string $value): self
    {
        return $this->where(sprintf('%s = ?', Helper::escapeMysqlSchemaNames($column)), $value);
    }

    public function whereNot(string $column, float|int|string $value): self
    {
        return $this->where(sprintf('%s <> ?', Helper::escapeMysqlSchemaNames($column)), $value);
    }

    public function whereBetween(string $column, float|int|string|null $from, float|int|string|null $to): self
    {
        return $this->where(sprintf('%s BETWEEN ? AND ?', Helper::escapeMysqlSchemaNames($column)), $from, $to);
    }

    public function whereIn(string $column, float|int|string|null ...$values): self
    {
        $count = count($values);
        if ($count === 0) {
            throw new InvalidQueryException('Invalid query: \'WHERE IN(...)\' must contains at least one value.');
        }

        $placeholders = str_repeat('?, ', $count - 1) . '?';
        return $this->where(
            sprintf('%s IN(%s)', Helper::escapeMysqlSchemaNames($column), $placeholders),
            ...array_values($values)
        );
    }

    public function whereNotIn(string $column, float|int|string|null ...$values): self
    {
        $count = count($values);
        if ($count === 0) {
            throw new InvalidQueryException('Invalid query: \'WHERE IN(...)\' must contains at least one value.');
        }

        $placeholders = str_repeat('?, ', $count - 1) . '?';
        return $this->where(
            sprintf('%s NOT IN(%s)', Helper::escapeMysqlSchemaNames($column), $placeholders),
            ...array_values($values)
        );
    }

    public function whereLike(string $column, float|int|string $value): self
    {
        return $this->where(sprintf('%s LIKE ?', Helper::escapeMysqlSchemaNames($column)), $value);
    }

    public function whereNotLike(string $column, float|int|string $value): self
    {
        return $this->where(sprintf('%s NOT LIKE ?', Helper::escapeMysqlSchemaNames($column)), $value);
    }

    public function whereNull(string $column): self
    {
        return $this->where(sprintf('%s IS NULL', Helper::escapeMysqlSchemaNames($column)));
    }

    public function whereNotNull(string $column): self
    {
        return $this->where(sprintf('%s IS NOT NULL', Helper::escapeMysqlSchemaNames($column)));
    }

    protected function hasWhereClause(): bool
    {
        return (bool)count($this->whereConditions);
    }

    protected function getWhereString(): string
    {
        if (!$this->hasWhereClause()) {
            return '';
        }

        return sprintf("WHERE %s", implode(" AND ", $this->whereConditions));
    }

    protected function getWhereParams(): array
    {
        return $this->whereParams;
    }
}
