<?php

namespace Idos\Controllers;

use Idos\Controllers\BaseController;
use Idos\Http\HttpRequest;

class HomeController extends BaseController
{
    public function index(): void {
        $this->view('form.view', ['html_title' => 'Index']);
    }

    public function submitForm(HttpRequest $request): void {
        echo "Method: " . $request->requestMethod;
    }
}