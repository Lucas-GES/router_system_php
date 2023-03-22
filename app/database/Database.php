<?php
namespace app\database;
class Database
{
    private $host =  ''; //host of connection example: localhost
    private $dbname = ''; //Name of database
    private $user = ''; //username of database
    private $password = ''; //Password of database here

    public function connect()
    {
        return new \PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->password, [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
        ]);
    }

}