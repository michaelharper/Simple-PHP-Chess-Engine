<?php

/**
 * Created by PhpStorm.
 * User: michaelharper
 * Date: 7/18/17
 * Time: 12:21 AM
 */
class Connection
{
    public static function make($config)
    {
        try {
            return new PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            die($e -> getMessage());
        }
    }
}