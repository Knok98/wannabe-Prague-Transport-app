<?php

declare(strict_types=1);

namespace Idos;

use Idos\Models\SessionManager;

class DIContainer
{
    private array $services = [];

    public function getSessionManager(): SessionManager {
        if (!isset($this->services['SessionManager'])) {
            $this->services['SessionManager'] = new SessionManager();
        }
        return $this->services['SessionManager'];
    }
}