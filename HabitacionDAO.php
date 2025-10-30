<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/Habitacion.php';

class HabitacionDAO {
    public function insertar($h) {
        $sql = "INSERT INTO habitacion VALUES (?, ?, ?, ?, ?)";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $h->id_habitacion, $h->numero, $h->tipo, $h->precio_noche, $h->estado_habitacion
        ]);
    }

    public function listar() {
        $sql = "SELECT * FROM habitacion";
        $con = Conexion::conectar();
        return $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $sql = "SELECT * FROM habitacion WHERE id_habitacion = ?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($h) {
        $sql = "UPDATE habitacion SET numero=?, tipo=?, precio_noche=?, estado_habitacion=? WHERE id_habitacion=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $h->numero, $h->tipo, $h->precio_noche, $h->estado_habitacion, $h->id_habitacion
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM habitacion WHERE id_habitacion=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function listarLibres() {
        $sql = "SELECT * FROM habitacion WHERE estado_habitacion = 'libre'";
        $con = Conexion::conectar();
        return $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>