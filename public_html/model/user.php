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
        WHERE u.rol = r.id
        ORDER BY u.id ASC";
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

    public function getId($username)
    {
        try {
            $this->getConnection();
            $query = sprintf("SELECT id FROM usuario WHERE usuario='%s'", $username);

            $result = $this->connection->query($query);
            return $result->fetch_row()[0];
        } catch (\Throwable $th) {
            echo "Error al buscar el id" . PHP_EOL;
        }
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

            // Segunda 'Capa de seguridaad': Formatear cada campo recibido para evitar ataques XSS
            $formatedParams = array_map(fn ($field): string => htmlspecialchars($field), $params);
            ['id' => $id, 'name' => $names, 'fullLastName' => $fullLastName, 'email' => $email, 'username' => $username] = $formatedParams;

            // Obtener contraseña en caso de que se haya enviado
            $password = $params['password'] ?? "";

            // ToDo: Cambios para aceptar mas de dos roles distintos
            $isAdmin = isset($params["adminCheck"]) ? 1 : 0;

            // Separar apellidos
            $namesArray = explode(" ", $fullLastName);
            if (isset($namesArray[0])) $lastName = $namesArray[0];
            if (isset($namesArray[1])) $secondLastName = $namesArray[1];

            // Hashear y "Salar" la contraseña
            $hash = password_hash($password, PASSWORD_BCRYPT);

            // Si la variable $id tiene información es porque se busca actualizar un registro
            if ($id) {
                $query = "UPDATE $this->table 
                        SET nombres=?, apellido_paterno=?, apellido_materno=?, usuario=?, correo=?, rol=?
                        WHERE id = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("sssssii", $names, $lastName, $secondLastName, $username, $email, $isAdmin, $id);
            } else {
                $query = "INSERT INTO $this->table 
                        (nombres, apellido_paterno, apellido_materno, usuario, correo, hash, rol)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("ssssssi", $names, $lastName, $secondLastName, $username, $email, $hash, $isAdmin);
            }
            return $stmt->execute();
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
