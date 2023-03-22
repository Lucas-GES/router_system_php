<?php

namespace app\controllers;
use app\controllers\Controller;

class HomeController extends Controller
{
    
    public function index(){
        session_start();
        $this->view('home', ['username' => $_SESSION['username']]);
    }

}