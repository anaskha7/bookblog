<?php

class Database
{
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'db';
        $this->dbname = getenv('DB_NAME') ?: 'book_blog';
        $this->user = getenv('DB_USER') ?: 'user';
        $this->password = getenv('DB_PASS') ?: 'secret';
    }

    public function getConnection(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        return new PDO($dsn, $this->user, $this->password, $options);
    }
}
