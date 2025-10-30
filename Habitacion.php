<?php
class Habitacion {
    public $id_habitacion, $numero, $tipo, $precio_noche, $estado_habitacion;
    public function __construct($id, $num, $tipo, $precio, $estado) {
        $this->id_habitacion = $id;
        $this->numero = $num;
        $this->tipo = $tipo;
        $this->precio_noche = $precio;
        $this->estado_habitacion = $estado;
    }
}
?>