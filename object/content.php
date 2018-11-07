<?php

/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 07-Nov-18
 * Time: 10:35 AM
 */

class Content
{
    private $connection;
    private $table_name = "content";

    public $id_content;
    public $title;
    public $url;
    public $state;
    public $description;

    public function __construct(PDO $db)
    {
        $this->connection = $db;
    }

    public function read(){
        $query = "SELECT * FROM " . $this->table_name;
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }
}