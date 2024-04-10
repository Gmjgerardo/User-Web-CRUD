<?php
session_start();

require_once("../private/config/config.php");
require_once("model/db.php");

// Verificar si se ingreso un controlador/acción (en caso contrario asignar los default)
if (!isset($_GET["controller"])) $_GET["controller"] = constant("DEFAULT_CONTROLLER");
if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

// Verificar la existencia del controlador ingresado
$controller_path = "controller/" . $_GET["controller"] . '.php';
if (!file_exists($controller_path)) $controller_path = 'controller/' . constant("DEFAULT_CONTROLLER") . '.php';

// Cargar el respectivo controlador
require_once $controller_path;  // Importar la clase del controlador
$controllerName = $_GET["controller"] . 'Controller';
$controller = new $controllerName();

// Arreglo para compartir información entre los controladores y las vistas
$dataToView["data"] = array();

// Verificar la existencia de la acción en el respectivo controlador y obtener la información retornada por el controlador
if (method_exists($controller, $_GET["action"])) $dataToView["data"] = $controller->{$_GET["action"]}();

// Cargar vistas 
require_once 'view/template/head.php';
require_once 'view/' . $controller->view . '.php';
require_once 'view/template/footer.php';
