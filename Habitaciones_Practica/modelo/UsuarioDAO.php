<?php
require_once __DIR__ . '/../conexion/Conexion.php';
require_once __DIR__ . '/Usuario.php';

class UsuarioDAO {
    public function insertar($u) {
        $sql = "INSERT INTO usuario VALUES (?, ?, ?, ?, ?, ?)";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $u->id_usuario, $u->nombre, $u->correo, $u->clave, $u->rol, $u->estado
        ]);
    }

    public function listar() {
        $sql = "SELECT * FROM usuario";
        $con = Conexion::conectar();
        return $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($id) {
        $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($u) {
        $sql = "UPDATE usuario SET nombre=?, correo=?, clave=?, rol=?, estado=? WHERE id_usuario=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([
            $u->nombre, $u->correo, $u->clave, $u->rol, $u->estado, $u->id_usuario
        ]);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM usuario WHERE id_usuario=?";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function validarCredenciales($correo, $clave) {
        $sql = "SELECT * FROM usuario WHERE correo = ? AND clave = ? AND estado = 'activo'";
        $con = Conexion::conectar();
        $stmt = $con->prepare($sql);
        $stmt->execute([$correo, $clave]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>