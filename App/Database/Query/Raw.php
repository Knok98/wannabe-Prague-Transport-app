<?php

declare(strict_types=1);

namespace Idos\Database\Query;

use Idos\Database\Query;

class Raw implements Query
{
    public function __construct(
        private readonly string $queryString,
        private readonly array $params = []
    ) {
    }

    public function getQueryString(): string
    {
        return $this->queryString;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
