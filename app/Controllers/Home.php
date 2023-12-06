<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {

        $db = \Config\Database::connect();
        $builder = $db-> table('authors');

        $query = $builder -> get();

        $result = $query -> getResult();
        return json_encode($result);

        return view('welcome_message');
    }
}
