<?php

declare(strict_types=1);

namespace Idos\Database\Builder\Clause;

trait Limit
{
    protected ?int $limit = null;

    public function limit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
}
