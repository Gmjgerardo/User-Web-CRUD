<?php
require_once 'model/user.php';

class userController
{
    public $page_title;
    public $view;

    private $userObj;

    public function __construct()
    {
        // Verificar si se logueo un usuario, en caso contrario redirigirlo al Login
        if (!isset($_SESSION["login"])) header('location:' . ROOT);
        else {
            $this->view = 'user_list';
            $this->page_title = 'Usuario';
            $this->userObj = new User();

            // Obtener rol del usuario logueado y almacenarlo en la sesión
            $userRol = $this->userObj->getRol($_SESSION["login"]["user"]);
            $_SESSION['login']["rol"] = $userRol;
        }
    }

    public function list()
    {
        $this->page_title = 'Listado de usuarios';
        return $this->userObj->getUsers();
    }

    public function edit($id = null)
    {
        $this->verifyUserPermission();
        $this->view = 'user_form';

        if (isset($_GET["id"])) {
            $this->page_title = 'Edición de usuario';
            $id = $_GET["id"];
            return $this->userObj->getUserById($id);
        } else $this->page_title = 'Registro de usuario';
    }

    public function save()
    {
        $this->verifyUserPermission();
        $this->view = 'user_form';
        $this->page_title = 'Usuario Registrado';

        $id = $this->userObj->save($_POST);
        $_GET["response"] = true;
        echo $id;
    }

    public function verifyUserPermission()
    {
        if ($_SESSION["login"]["rol"] < 1) header('location:' . ROOT . '?controller=user&action=list&msg=No tienes los permisos requeridos, consulta a un Administrador');
    }
}
