<?php

/**
 * Created by PhpStorm.
 * User: michaelharper
 * Date: 7/18/17
 * Time: 12:26 AM
 */
class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, 'Game');
    }
}