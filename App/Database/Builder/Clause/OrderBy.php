<?php

declare(strict_types=1);

namespace Idos\Database\Builder\Clause;

use Idos\Database\Helper;

trait OrderBy
{
    /** @var string[] */
    private array $orderBy = [];

    public function orderBy(string $expression): self
    {
        $this->orderBy[] = $expression;
        return $this;
    }

    public function orderByAsc(string $column):self
    {
        return $this->orderBy(sprintf('%s ASC', Helper::escapeMysqlSchemaNames($column)));
    }

    public function orderByDesc(string $column):self
    {
        return $this->orderBy(sprintf('%s DESC', Helper::escapeMysqlSchemaNames($column)));
    }

    protected function hasOrderByClause(): bool
    {
        return (bool)count($this->orderBy);
    }

    protected function getOrderByString(): string
    {
        if (!$this->hasOrderByClause()) {
            return '';
        }

        return sprintf("ORDER BY %s", implode(", ", $this->orderBy));
    }
}
