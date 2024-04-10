<?php
require_once("model/session.php");

class sessionController
{
    public $page_title;
    public $view;

    private $loginObj;

    public function __construct()
    {
        $this->page_title = "Iniciar Sesión";
        $this->view = "/template/login";
        $this->loginObj = new Session();
    }

    public function index()
    {
        if (isset($_SESSION["login"])) {
            header('location: ' . ROOT . "?controller=user&action=list");
        }
    }

    public function login()
    {
        $this->page_title = "Iniciar Sesión";
        $this->view = "/template/login";

        $_username = trim($_POST['username']);
        $_password = trim($_POST['password']);

        $_result = $this->loginObj->login($_username, $_password);

        if ($_result) {
            $_SESSION['login'] = array("user" => $_username);
            header('location: ' . ROOT . "?controller=user&action=list");
        } else {
            header('location:' . ROOT . "?msg=Credenciales incorrectas, por favor verifica la información");
        }
    }

    public function logout()
    {
        if (isset($_SESSION["login"])) {
            unset($_SESSION["login"]);
        }

        header("location:" . ROOT);
    }
}
