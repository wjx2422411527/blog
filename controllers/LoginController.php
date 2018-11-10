<?php
namespace controllers;
use PDO;
class LoginController{
    public function login(){
        view('login/login');
    }
    public function dologin(){
        $a = new \models\Login;
        $a->login($_POST);
    }
}