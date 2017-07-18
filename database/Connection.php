<?php

/**
 * Created by PhpStorm.
 * User: michaelharper
 * Date: 7/18/17
 * Time: 12:21 AM
 */
class Connection
{
    public static function make() {
        try {
            return $pdo = new PDO('mysql:host=127.0.0.1;dbname=mechanical_jerk', 'root', 'root');
        } catch (PDOException $e) {
            die($e-getMessage());
        }
    }
}

$pdo = Connection::make();