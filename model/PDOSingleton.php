<?php

namespace model;

class PDOSingleton
{

    private static $instance = null;


    public static function get(): \PDO
    {
        if (self::$instance === null) {
            self::$instance = self::create();
        }
        return self::$instance;
    }

    public static function create(): \PDO
    {
        return new \PDO('mysql:host=localhost;dbname=amja00;charset=utf8;port=3306', 'amja00', '');
    }
}