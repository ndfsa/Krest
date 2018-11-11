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

    public function read(string $s)
    {
        $query = "SELECT * FROM " . $this->table_name .
            " WHERE title LIKE '%" . $s . "%'" . " OR description LIKE '%" . $s . "%'";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " VALUES(null, '"
            . $this->title . "', '"
            . $this->url . "', '"
            . $this->state . "', '"
            . $this->description . "')";
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function clean_attributes()
    {
        $this->id_content = null;
        $this->title = null;
        $this->url = null;
        $this->state = null;
        $this->description = null;

    }

    public function remove($id_content)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_content = " .$id_content;
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

}