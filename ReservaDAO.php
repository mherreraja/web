<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/Reserva.php';

class ReservaDAO {
    public function insertar($r) {
        $sql = "INSERT INTO reserva VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $r->id_reserva, $r->habitacion_id, $r->cliente_id, $r->fecha_ingreso,
            $r->fecha_salida, $r->noches, $r->monto_total, $r->estado_reserva
        ]);
    }

    public function listar() {
        $sql = "SELECT * FROM reserva";
        $con = Conexion::conectar();
        return $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $sql = "SELECT * FROM reserva WHERE id_reserva = ?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($r) {
        $sql = "UPDATE reserva SET habitacion_id=?, cliente_id=?, fecha_ingreso=?, fecha_salida=?, noches=?, monto_total=?, estado_reserva=? WHERE id_reserva=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $r->habitacion_id, $r->cliente_id, $r->fecha_ingreso, $r->fecha_salida,
            $r->noches, $r->monto_total, $r->estado_reserva, $r->id_reserva
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM reserva WHERE id_reserva=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function calcularMonto($habitacion_id, $noches) {
        $sql = "SELECT precio_noche FROM habitacion WHERE id_habitacion = ?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        $stmt->execute([$habitacion_id]);
        $habitacion = $stmt->fetch(PDO::FETCH_ASSOC);
        return $habitacion ? $habitacion['precio_noche'] * $noches : 0;
    }
}
?>