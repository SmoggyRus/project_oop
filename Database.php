<?php

// Паттерн Singleton - заключается в том, что у класса будет только 1 экземпляра объекта.
// Конструктор (__consctruct) объявляется через private, чтобы запретить создание объектов через new
class Database
{
    private static $instance = null;
    private $pdo;
    private function __construct(){
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=project-oop', 'root', '');
            echo "Connected successfully";
        } catch(PDOException $exception) {
            die($exception->getMessage());
        }
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new Database();
        }
        return self::$instance;
    }
}