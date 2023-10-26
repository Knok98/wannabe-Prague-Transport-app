<?php

declare(strict_types=1);

namespace Idos\Controllers;

use Idos\Views\View;

class BaseController
{
    protected function view(string $template, ?array $context): void {
        $view = new View($template, $context);
        try {
            $view->show();
        } catch (\Exception $e) {
            print $e->getMessage();
        }
    }
}