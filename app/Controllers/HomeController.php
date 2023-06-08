<?php

namespace App\Controllers;

use App\Helpers\Params;
use App\Helpers\View;
use App\Models\User;

class HomeController
{
    public function index()
    {
        // $users = User::getAll();

        return View::render('home/home.php');
    }

    public function get_user()
    {
        $users = array();
        $users[] = User::find(Params::get('id'));

        return View::render('home/welcome.php', [
            'users' => $users
        ]);
    }

    public function test()
    {
        return View::render('home/home.php');
    }

    // public function create_user()
    // {
    //     $user = (object) [
    //         'first_name' => 'Myra',
    //         'last_name' => 'Dalton',
    //         'email' => 'myra@example.com4',
    //         'age' => 21,
    //         'country' => 'Sweden'
    //     ];

    //     User::create($user);
    // }

}