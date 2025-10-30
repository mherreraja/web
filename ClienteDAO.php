<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/Cliente.php';

class ClienteDAO {
    public function insertar($c) {
        $sql = "INSERT INTO cliente VALUES (?, ?, ?, ?, ?, ?)";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $c->id_cliente, $c->dni, $c->nombre_completo, $c->telefono, $c->correo, $c->estado
        ]);
    }

    public function listar() {
        $sql = "SELECT * FROM cliente";
        $con = Conexion::conectar();
        return $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $sql = "SELECT * FROM cliente WHERE id_cliente = ?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($c) {
        $sql = "UPDATE cliente SET dni=?, nombre_completo=?, telefono=?, correo=?, estado=? WHERE id_cliente=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $c->dni, $c->nombre_completo, $c->telefono, $c->correo, $c->estado, $c->id_cliente
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM cliente WHERE id_cliente=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>