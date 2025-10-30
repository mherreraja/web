<?php
class Usuario {
    public $id_usuario, $nombre, $correo, $clave, $rol, $estado;
    public function __construct($id, $nombre, $correo, $clave, $rol, $estado) {
        $this->id_usuario = $id;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->rol = $rol;
        $this->estado = $estado;
    }
}
?>