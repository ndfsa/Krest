<?php

/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 09-Nov-18
 * Time: 1:14 PM
 */
class User
{
    private $connection;
    private $table_name = "user";

    public $id_user;
    public $name;
    public $surname;
    public $username;
    public $password;
    public $type;
    public $birth;

    public function __construct(PDO $db)
    {
        $this->connection = $db;
    }

    public function create()
    {
        $op = ['salt' => $this->username . ':::krestUserUPBDatabase', 'cost' => 13];
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT, $op);
        $query = "INSERT INTO " . $this->table_name . " VALUES(null, '"
            . $this->name . "', '"
            . $this->surname . "', '"
            . $this->username . "', '"
            . $hashed_password . "','"
            . $this->type . "', '"
            . $this->birth . "')";
        $statement = $this->connection->prepare($query);
        $statement->execute();

    }

    public function get_user($username)
    {
        $query = "SELECT name, surname, username, type, birth FROM " . $this->table_name
            . " WHERE username = '" . $username . "'";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function verify_sign_in(string $username, string $password)
    {
        $op = ['salt' => $username . ':::krestUserUPBDatabase', 'cost' => 13];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $op);
        $query = "SELECT * FROM " . $this->table_name . " WHERE username LIKE '" . $username
            . "' AND password LIKE '" . $hashed_password . "'";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement;
    }

    public function update_password($id_user)
    {
        $op = ['salt' => $this->username . ':::krestUserUPBDatabase', 'cost' => 13];
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT, $op);
        $query = "UPDATE " . $this->table_name
            . " SET password = '" . $hashed_password
            . "', username = '" . $this->username
            . "' WHERE id_user = " . $id_user;
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function remove($id_user)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_user = " . $id_user;
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function update($id_user)
    {
        $query = "UPDATE " . $this->table_name
            . " SET name = '" . $this->name
            . "', surname = '" . $this->surname
            . "', type = '" . $this->type
            . "', birth = '" . $this->birth
            . "' WHERE id_user = " . $id_user;
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }

    public function clean_attributes()
    {
        $this->id_user = null;
        $this->name = null;
        $this->surname = null;
        $this->username = null;
        $this->password = null;
        $this->type = null;
        $this->birth = null;
    }
}