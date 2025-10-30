<?php
class Reserva {
    public $id_reserva, $habitacion_id, $cliente_id, $fecha_ingreso, $fecha_salida, $noches, $monto_total, $estado_reserva;
    public function __construct($id, $hab, $cli, $fechaIn, $fechaOut, $noches, $monto, $estado) {
        $this->id_reserva = $id;
        $this->habitacion_id = $hab;
        $this->cliente_id = $cli;
        $this->fecha_ingreso = $fechaIn;
        $this->fecha_salida = $fechaOut;
        $this->noches = $noches;
        $this->monto_total = $monto;
        $this->estado_reserva = $estado;
    }
}
?>