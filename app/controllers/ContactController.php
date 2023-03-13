<?php
namespace app\controllers;
use app\controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $this->view('contact', ['title' => 'Contact']);
    }

    public function store($params)
    {
        var_dump($params->email);
    }
}