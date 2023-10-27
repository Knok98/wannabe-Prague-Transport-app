<?php

declare(strict_types=1);

namespace Idos\Database;

interface Executable
{
    public function execute(): Result;
}
