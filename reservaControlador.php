<?php
session_start();
require_once '../modelo/ReservaDAO.php';
require_once '../modelo/Reserva.php';

$dao = new ReservaDAO();

try {
    if ($_POST['accion'] == 'Registrar') {
        // Calcular monto automáticamente
        $monto_total = $dao->calcularMonto($_POST['habitacion_id'], $_POST['noches']);
        
        $r = new Reserva(
            $_POST['id_reserva'], $_POST['habitacion_id'], $_POST['cliente_id'], 
            $_POST['fecha_ingreso'], $_POST['fecha_salida'], $_POST['noches'], 
            $monto_total, $_POST['estado_reserva']
        );
        if ($dao->insertar($r)) {
            $_SESSION['mensaje'] = "Reserva registrada exitosamente";
        }
    } elseif ($_POST['accion'] == 'Actualizar') {
        $monto_total = $dao->calcularMonto($_POST['habitacion_id'], $_POST['noches']);
        
        $r = new Reserva(
            $_POST['id_reserva'], $_POST['habitacion_id'], $_POST['cliente_id'], 
            $_POST['fecha_ingreso'], $_POST['fecha_salida'], $_POST['noches'], 
            $monto_total, $_POST['estado_reserva']
        );
        if ($dao->actualizar($r)) {
            $_SESSION['mensaje'] = "Reserva actualizada exitosamente";
        }
    } elseif ($_GET['accion'] == 'Eliminar' && isset($_GET['id'])) {
        if ($dao->eliminar($_GET['id'])) {
            $_SESSION['mensaje'] = "Reserva eliminada exitosamente";
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
}

header("Location: ../vista/reservas.php");
?>