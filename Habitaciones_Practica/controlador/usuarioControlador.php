<?php
session_start();
require_once '../modelo/UsuarioDAO.php';
require_once '../modelo/Usuario.php';

$dao = new UsuarioDAO();

if ($_POST['accion'] == 'Login') {
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $usuario = $dao->validarCredenciales($correo, $clave);
    if ($usuario) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../vista/dashboard.php");
    } else {
        $_SESSION['error_login'] = "Correo o clave incorrectos";
        header("Location: ../vista/login.php");
    }
    exit();
} elseif (isset($_GET['accion']) && $_GET['accion'] == 'Logout') {
    session_destroy();
    header("Location: ../vista/login.php");
    exit();
}
?>