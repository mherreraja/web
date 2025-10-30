<?php
class Cliente {
    public $id_cliente, $dni, $nombre_completo, $telefono, $correo, $estado;
    public function __construct($id, $dni, $nombre, $tel, $correo, $estado) {
        $this->id_cliente = $id;
        $this->dni = $dni;
        $this->nombre_completo = $nombre;
        $this->telefono = $tel;
        $this->correo = $correo;
        $this->estado = $estado;
    }
}
?>