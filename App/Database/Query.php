<?php

declare(strict_types=1);

namespace Idos\Database;

interface Query
{
    public function getQueryString(): string;

    public function getParams(): array;
}
