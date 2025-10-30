<?php
session_start();
require_once '../modelo/ClienteDAO.php';
require_once '../modelo/Cliente.php';

$dao = new ClienteDAO();

try {
    if ($_POST['accion'] == 'Registrar') {
        $c = new Cliente($_POST['id_cliente'], $_POST['dni'], $_POST['nombre_completo'], $_POST['telefono'], $_POST['correo'], $_POST['estado']);
        if ($dao->insertar($c)) {
            $_SESSION['mensaje'] = "Cliente registrado exitosamente";
        }
    } elseif ($_POST['accion'] == 'Actualizar') {
        $c = new Cliente($_POST['id_cliente'], $_POST['dni'], $_POST['nombre_completo'], $_POST['telefono'], $_POST['correo'], $_POST['estado']);
        if ($dao->actualizar($c)) {
            $_SESSION['mensaje'] = "Cliente actualizado exitosamente";
        }
    } elseif ($_GET['accion'] == 'Eliminar' && isset($_GET['id'])) {
        if ($dao->eliminar($_GET['id'])) {
            $_SESSION['mensaje'] = "Cliente eliminado exitosamente";
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: ../vista/clientes.php");
?>