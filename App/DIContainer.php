<?php

declare(strict_types=1);

namespace Idos;

use Idos\Database\Db;
use Idos\Database\DbFactory;
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

    public function getDb(): Db {
        if (! isset($this->services['Db'])) {
            $db = new DbFactory(
                "mysqldb",
                "root",
                "devstack",
                "idos",
                "utf8"
            );
            $this->services['Db'] = $db->create();
        }
        return $this->services['Db'];
    }
}