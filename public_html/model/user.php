<?php
class User
{
    private $table = 'usuario';
    private $connection;

    public function __construct()
    {
    }


    public function getConnection()
    {
        $databaseObj = new Db();
        $this->connection = $databaseObj->connection;
    }

    public function getUsers()
    {
        $this->getConnection();
        $query = "SELECT u.id, u.nombres, u.apellido_paterno, u.apellido_materno, u.usuario, r.nombre, u.fecha_creacion
        FROM usuario u, rol r
        WHERE u.rol = r.id";
        $result = $this->connection->query($query);

        return $result->fetch_all();
    }

    public function getUserById($id)
    {
        $resultData = false;

        if (!is_null($id)) {
            $this->getConnection();
            try {
                $query = "SELECT * FROM $this->table WHERE id = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("i", $id);

                $stmt->execute();

                if ($result = $stmt->get_result()) {
                    $resultData = $result->fetch_all();
                }
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
        }

        return $resultData;
    }

    public function getRol($username)
    {
        try {
            $this->getConnection();
            $query = sprintf("SELECT rol FROM usuario WHERE usuario='%s'", $username);

            $result = $this->connection->query($query);
            return $result->fetch_row()[0];
        } catch (\Throwable $th) {
            echo "Error al buscar el rol" . PHP_EOL;
        }
    }

    public function save($params)
    {
        try {
            $this->getConnection();
            $secondLastName = null;
            ['name' => $names, 'fullLastName' => $fullLastName, 'email' => $email, 'username' => $username, 'password' => $password, 'confirm' => $confirm] = $params;

            // ToDo: Cambios para aceptar mas de dos roles distintos
            $isAdmin = isset($params["adminCheck"]) ? 1 : 0;

            // Separar apellidos
            $namesArray = explode(" ", $fullLastName);
            if (isset($namesArray[0])) $lastName = $namesArray[0];
            if (isset($namesArray[1])) $secondLastName = $namesArray[1];

            // Hashear y "Salar" la contraseña
            $hash = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO $this->table 
            (nombres, apellido_paterno, apellido_materno, usuario, correo, hash, rol)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ssssssi", $names, $lastName, $secondLastName, $username, $email, $hash, $isAdmin);

            if ($stmt->execute()) {
                echo "Se ejecuto la query!";
            } else {
                echo "Hubo un error";
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function deleteUserById($id)
    {
        try {
            $this->getConnection();
            $query = "DELETE FROM " . $this->table . " WHERE id = ?";

            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("i", $id);

            return $stmt->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
