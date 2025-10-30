<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once '../modelo/HabitacionDAO.php';
require_once '../modelo/ReservaDAO.php';

$habitacionDAO = new HabitacionDAO();
$reservaDAO = new ReservaDAO();

$totalHabitaciones = count($habitacionDAO->listar());
$habitacionesLibres = count($habitacionDAO->listarLibres());
$reservasActivas = count(array_filter($reservaDAO->listar(), function($r) {
    return $r['estado_reserva'] == 'activa';
}));

// CALCULAR INGRESO ESTIMADO DEL DÍA
$ingresoEstimado = 0;
$reservasHoy = array_filter($reservaDAO->listar(), function($r) {
    return $r['estado_reserva'] == 'activa' && $r['fecha_ingreso'] == date('Y-m-d');
});
foreach ($reservasHoy as $reserva) {
    $ingresoEstimado += $reserva['monto_total'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - HotelReservas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏨</text></svg>">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f1e9;
            color: #5a4d3c;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #dabe99;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            color: #3e2f1c;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }
        nav {
            text-align: center;
            background: #dabe99;
            padding: 10px;
            margin-bottom: 20px;
        }
        nav a {
            margin: 0 15px;
            color: #3e2f1c;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .metricas {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        .metrica {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 10px;
            min-width: 200px;
        }
        .metrica h3 {
            margin: 0 0 10px 0;
            color: #7c6830;
        }
        .metrica .numero {
            font-size: 24px;
            font-weight: bold;
            color: #3e2f1c;
        }
        .metrica .subtexto {
            font-size: 14px;
            color: #7c6830;
            margin-top: 5px;
        }
        .fecha {
            text-align: center;
            color: #7c6830;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>HotelReservas - Panel de Control</header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="habitaciones.php">Habitaciones</a>
        <a href="reservas.php">Reservas</a>
        <a href="clientes.php">Clientes</a>
        <a href="../controlador/usuarioControlador.php?accion=Logout">Salir</a>
    </nav>
    <main style="max-width:960px; margin:auto; background:#fff; padding:20px; border-radius:8px;">
        <h2>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h2>
        
        <div class="fecha">
            <strong>Fecha actual:</strong> <?= date('d/m/Y') ?>
        </div>
        
        <div class="metricas">
            <div class="metrica">
                <h3>Habitaciones Ocupadas</h3>
                <div class="numero"><?= $totalHabitaciones - $habitacionesLibres ?> / <?= $totalHabitaciones ?></div>
                <div class="subtexto">Total de habitaciones</div>
            </div>
            <div class="metrica">
                <h3>Habitaciones Libres</h3>
                <div class="numero"><?= $habitacionesLibres ?></div>
                <div class="subtexto">Disponibles para reservar</div>
            </div>
            <div class="metrica">
                <h3>Reservas Activas</h3>
                <div class="numero"><?= $reservasActivas ?></div>
                <div class="subtexto">Reservas en curso</div>
            </div>
            <div class="metrica">
                <h3>Ingreso Estimado Hoy</h3>
                <div class="numero">S/. <?= number_format($ingresoEstimado, 2) ?></div>
                <div class="subtexto"><?= count($reservasHoy) ?> reservas para hoy</div>
            </div>
        </div>
        
        <div style="margin-top:30px; padding:20px; background:#f8f9fa; border-radius:8px;">
            <h3 style="color:#3e2f1c; margin-top:0;">Resumen Rápido</h3>
            <p>Desde aquí puedes gestionar todas las operaciones del hotel:</p>
            <ul>
                <li><strong>Habitaciones:</strong> Ver, crear, editar y eliminar habitaciones</li>
                <li><strong>Reservas:</strong> Gestionar reservas activas y realizar check-in/check-out</li>
                <li><strong>Clientes:</strong> Administrar la información de los clientes</li>
            </ul>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>