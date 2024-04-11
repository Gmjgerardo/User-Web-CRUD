<?php
require_once 'model/user.php';

class userController
{
    public $page_title;
    public $view;

    private $userObj;

    public function __construct()
    {
        // Verificar si se logueo un usuario, o si esta en proceso de registro en caso contrario redirigirlo al Login
        if (!isset($_SESSION["onRegister"]) && !isset($_SESSION["login"])) header('location:' . ROOT);
        else {
            // Permitir la interacción con la BD para registrar el usuario
            $this->userObj = new User();

            if (isset($_SESSION["login"])) {
                $this->view = 'user_list';
                $this->page_title = 'Usuario';

                // Obtener id del usuario logueado y almacenarlo en la sesión
                $userId = $this->userObj->getId($_SESSION["login"]["user"]);
                $_SESSION["login"]["id"] = $userId;

                // Obtener rol del usuario logueado y almacenarlo en la sesión
                $userRol = $this->userObj->getRol($_SESSION["login"]["user"]);
                $_SESSION["login"]["rol"] = $userRol;
            }
        }
    }

    public function list()
    {
        $this->page_title = 'Listado de usuarios';
        return $this->userObj->getUsers();
    }

    public function edit($id = null)
    {
        $id = $_GET["id"] ?? false;

        if ($_SESSION["login"]["id"] != $id) $this->verifyUserPermission();

        $this->view = 'user_form';

        if ($id) {
            $this->page_title = 'Edición de usuario';
            $id = $_GET["id"];

            if ($result = $this->userObj->getUserById($id)) return $result;

            // En caso de no existir el usuario, redirigir al listado
            else header('location:' . ROOT);
        } else $this->page_title = 'Registro de usuario';
    }

    public function save()
    {
        $this->view = "user_confirm";
        $this->page_title = "Confirmación de modificaciones";

        // Controlar si esta logueado o si esta registrandose por primera vez
        if (isset($_SESSION["onRegister"]) or isset($_SESSION["login"])) {
            $result = $this->userObj->save($_POST);

            unset($_SESSION["onRegister"]);
            return $result;
        }
    }

    public function delete($id = null)
    {
        $this->verifyUserPermission();

        $this->view = 'user_delete';
        $this->page_title = 'Eliminar Usuario';

        if (isset($_GET["id"])) $id = $_GET["id"];

        return ($this->userObj->getUserById($id));
    }

    public function confirmDelete()
    {
        $this->verifyUserPermission();

        $this->view = 'user_delete';
        $this->page_title = 'Eliminar Usuario';
        return $this->userObj->deleteUserById($_POST["id"]);
    }

    public function verifyUserPermission()
    {
        if ($_SESSION["login"]["rol"] < 1) header('location:' . ROOT . '?controller=user&action=list&msg=No tienes los permisos requeridos, consulta a un Administrador');
    }
}
