<?php

namespace App\DAO\Mysql;

abstract class Conexao
{
    /** @var \PDO
     * 
     */
    protected $pdo;
    public function __construct()
    {


       
        $dsn = "mysql:host=127.0.0.1;dbname=oauth;port=3306";
        $this->pdo = new \PDO($dsn, 'root', '');
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );

    }

}