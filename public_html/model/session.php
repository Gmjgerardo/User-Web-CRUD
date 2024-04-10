<?php
class Session
{
    private $connection;

    public function __construct()
    {
        $databaseObj = new Db();
        $this->connection = $databaseObj->connection;
    }

    public function login($username, $password)
    {
        $query = "SELECT hash FROM usuario WHERE usuario =?";

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $stmt->bind_result($hash);

        if ($stmt->fetch()) {
            if (password_verify($password, $hash))
                return true;
            else
                return false;
        }
    }
}
