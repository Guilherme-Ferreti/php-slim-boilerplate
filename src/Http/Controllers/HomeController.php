<?php

namespace App\Http\Controllers;

class HomeController extends BaseController
{
    public function __invoke()
    {
        return $this->view('site.index', ['title' => 'Homepage! Welcome']);
    }
}
