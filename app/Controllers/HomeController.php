<?php
namespace App\Controllers;


class HomeController{

    public function index(){

        echo file_get_contents('index.html');
    }
}