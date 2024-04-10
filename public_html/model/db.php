<?php
require_once("../private/config/config.php"); // Importación de constantes para la conexión de la BD

class Db
{
    // Variables accesible para los controladores y modelos
    public $connection;

    public function __construct()
    {
        try {
            $this->connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

            if ($this->connection->connect_errno) {
                echo "Fallo al conectar a MySQL: (" . $this->connection->connect_errno . ") " . $this->connection->connect_error;
                exit();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function close()
    {
        $this->connection->close();
    }
}
