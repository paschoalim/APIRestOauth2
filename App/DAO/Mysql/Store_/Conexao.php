<?php

namespace App\DAO\Mysql\Store;

abstract class Conexao
{
    /** @var \PDO
     * 
     */
    protected $pdo;
    public function __construct()
    {
        $host = getenv('MYSQL_HOST');
        $port = getenv('MYSQL_PORT');
        $user = getenv('MYSQL_USER');
        $pass = getenv('MYSQL_PASSWORD');
        $dbname = getenv('MYSQL_DBNAME');

       
        $dsn = "mysql:host=127.0.0.1;dbname=oauth;port=3306";
        $this->pdo = new \PDO($dsn, 'root', '');
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );

    }

}