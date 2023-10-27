<?php

declare(strict_types=1);

namespace Idos\Database\Builder;

use Idos\Database\Query;

interface Builder
{
    public function getQuery(): Query;
}
