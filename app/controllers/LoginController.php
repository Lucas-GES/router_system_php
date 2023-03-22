<?php

namespace app\controllers;

use app\controllers\Controller;
use app\database\Database;
use stdClass;

//Need to create registration table with columns username and password, with auto-increment id to store de user
class LoginController extends Controller
{

    // Commands to get data from database
    /*
     $variable = new Database(); <-- Class with database connection
     $connect = $variable->connect(); <-- method that make the connection with database
     $query = $connect->prepare('INSERT INTO table_name(id, name, created_at, updated_at) 
     VALUES(null, :name, :created_at)'); <-- Here is where you pass the query to prepare to send to database
     $created_at = date('Y-m-d'); <-- define the value of the binded variable in the query :created_at or the others
     $query->bindParam(":name", $data->name); <-- bind the value comming from method params
     $query->execute(); <-- then send the query to database

     if is a get method you need to use a try catch block
     try{
        // All the code above here but with a select query
        // then create a variable to store the data
        $query = $variable->query('SELECT * FROM table_name);
        $query->execute();
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode($data); <-- will send the data returned from database

     }catch(\PDOException $e){
        var_dump($e->getMessage());
     }
    */

    public function index()
    {
        $this->view('login', ['title' => 'Login']);
    }

    public function sign()
    {
        $this->view('sign', ['title' => 'SignUp']);
    }

    public function signup(stdClass $data)
    {
        try {
            $db = new Database();
            $connect = $db->connect();
            $query_verify_user = $connect->query("SELECT * from registration WHERE username LIKE '$data->username'");
            $verify_user = $query_verify_user->fetchAll(\PDO::FETCH_ASSOC);
            if (count($verify_user) > 0) {
                $this->view('sign', ['title' => 'SignIn', 'user' => true]);
            } else {
                $query = $connect->prepare('INSERT INTO registration(username, password) VALUES(:username, :password)');
                $query->bindParam(":username", $data->username);
                $query->bindParam(":password", $data->password);
                $query->execute();
                $this->view('sign', ['title' => 'SignIn', 'new_user' => true]);
            }
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function login(stdClass $data)
    {
        try {
            $db = new Database();
            $connect = $db->connect();
            $query = $connect->query("SELECT * FROM registration WHERE username LIKE '$data->username' AND password LIKE '$data->password'");
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            if(count($result) > 0){
                session_start();
                $_SESSION['username']=$data->username;
                header('location:/home');
            }else{
                $this->view('login', ['not_found' => true]);
            }
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('location:/');
    }
}
