<?php

declare(strict_types=1);

namespace Idos\Database\Builder;

use Idos\Database\Query;
use Idos\Database\Query\Raw;

class Append implements Builder
{
    private array $queryString = [];
    private array $params = [];

    /**
     * @param string $queryString
     * @param array<float|int|string|null> $params
     * @return $this
     */
    public function append(string $queryString, array $params = []): self
    {
        $this->queryString[] = $queryString;
        $this->params = array_merge($this->params, array_values($params));
        return $this;
    }

    public function getQuery(): Query
    {
        return new Raw(implode(' ', $this->queryString), $this->params);
    }
}
