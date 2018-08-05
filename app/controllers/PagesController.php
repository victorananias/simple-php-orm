<?php

namespace App\Controllers;

class PagesController {

    public function index() {
        return view('index');
    }

    public function sobre() {
        return view('sobre');
    }

    public function contato() {
        return view('contato');
    }
}