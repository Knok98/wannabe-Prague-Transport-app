<?php

declare(strict_types=1);

namespace Idos\Database\Builder;

use Idos\Database\Db;
use Idos\Database\Exception\DbException;
use Idos\Database\Executable;
use Idos\Database\Helper;
use Idos\Database\Query;
use Idos\Database\Result;

class Select implements Builder, Executable
{
    use Clause\Limit;
    use Clause\Offset;
    use Clause\OrderBy;
    use Clause\Where;

    private array $columns = [];

    public function __construct(
        private readonly Db $database,
        private readonly string $table,
    ) {
    }

    public function columns(string ...$columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function getQuery(): Query
    {
        $builder = new Append();

        $builder->append(sprintf("SELECT %s", Helper::columnListToQuery($this->columns, '*')));

        $builder->append(sprintf("FROM %s", Helper::escapeMysqlSchemaNames($this->table)));

        if ($this->hasWhereClause()) {
            $builder->append($this->getWhereString(), $this->getWhereParams());
        }

        if ($this->hasOrderByClause()) {
            $builder->append($this->getOrderByString());
        }

        if ($this->limit !== null) {
            $builder->append("LIMIT ?", [$this->limit]);
        }

        if ($this->offset !== null) {
            $builder->append("OFFSET ?", [$this->offset]);
        }

        return $builder->getQuery();
    }

    /**
     * @throws DbException
     */
    public function execute(): Result
    {
        return $this->database->executeQuery($this->getQuery());
    }

    public function fetchRow(): ?array
    {
        return $this->execute()->fetchRow();
    }

    public function fetchColumn(int $column = 0): mixed
    {
        return $this->execute()->fetchColumn($column);
    }
}
