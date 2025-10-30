<?php
session_start();
require_once '../modelo/HabitacionDAO.php';
require_once '../modelo/Habitacion.php';

$dao = new HabitacionDAO();

try {
    if ($_POST['accion'] == 'Registrar') {
        $h = new Habitacion($_POST['id_habitacion'], $_POST['numero'], $_POST['tipo'], $_POST['precio_noche'], $_POST['estado_habitacion']);
        if ($dao->insertar($h)) {
            $_SESSION['mensaje'] = "Habitación registrada exitosamente";
        }
    } elseif ($_POST['accion'] == 'Actualizar') {
        $h = new Habitacion($_POST['id_habitacion'], $_POST['numero'], $_POST['tipo'], $_POST['precio_noche'], $_POST['estado_habitacion']);
        if ($dao->actualizar($h)) {
            $_SESSION['mensaje'] = "Habitación actualizada exitosamente";
        }
    } elseif ($_GET['accion'] == 'Eliminar' && isset($_GET['id'])) {
        if ($dao->eliminar($_GET['id'])) {
            $_SESSION['mensaje'] = "Habitación eliminada exitosamente";
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: ../vista/habitaciones.php");
?>