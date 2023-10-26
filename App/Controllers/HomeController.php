<?php

namespace Idos\Controllers;

use Idos\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index(): void {
        $this->view('form.view', ['html_title' => 'Index']);
    }

    public function submitForm(): void {
        // zpracování formuláře
    }
}