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

    public $id_content;
    public $title;
    public $url;
    public $state;
    public $ext;
    public $description;

    public function __construct(PDO $db)
    {
        $this->connection = $db;
    }

    public function read(string $s)
    {
        $query = "CALL get_content('" . $s . "')";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function getAll()
    {
        $query = "CALL get_content_filtered()";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function readOne(int $id_content)
    {
        $query = "CALL get_one('" . $id_content . "')";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function create($id_user)
    {
        $query = "CALL ins_content('"
            . $this->title . "', '"
            . $this->url . "', '"
            . $this->state . "', '"
            . $this->ext . "', '"
            . $this->description . "', " . $id_user . ")";
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function modify($id_content)
    {
        $query = "CALL mod_content('"
            . $this->title . "', '"
            . $this->url . "', '"
            . $this->state . "', '"
            . $this->ext . "', '"
            . $this->description . "', " . $id_content . ")";
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function clean_attributes()
    {
        $this->id_content = null;
        $this->title = null;
        $this->url = null;
        $this->state = null;
        $this->ext = null;
        $this->description = null;

    }

    public function remove($id_content)
    {
        $query = "CALL delete_one(" . $id_content . ")";
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }
}