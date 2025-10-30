<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once '../modelo/ReservaDAO.php';
$dao = new ReservaDAO();
$reservas = $dao->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservas - HotelReservas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏨</text></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
        main {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header>Gestión de Reservas</header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="habitaciones.php">Habitaciones</a>
        <a href="reservas.php">Reservas</a>
        <a href="clientes.php">Clientes</a>
        <a href="../controlador/usuarioControlador.php?accion=Logout">Salir</a>
    </nav>
    <main>
        <a href="editar_reserva.php" class="btn btn-primary mb-3">Nueva Reserva</a>
        
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensaje'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-warning">
                    <tr>
                        <th>ID Reserva</th>
                        <th>Habitación ID</th>
                        <th>Cliente ID</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Salida</th>
                        <th>Noches</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reservas as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['id_reserva']) ?></td>
                        <td><?= htmlspecialchars($r['habitacion_id']) ?></td>
                        <td><?= htmlspecialchars($r['cliente_id']) ?></td>
                        <td><?= htmlspecialchars($r['fecha_ingreso']) ?></td>
                        <td><?= htmlspecialchars($r['fecha_salida']) ?></td>
                        <td><?= htmlspecialchars($r['noches']) ?></td>
                        <td>S/. <?= htmlspecialchars($r['monto_total']) ?></td>
                        <td>
                            <?php 
                                $badgeClass = [
                                    'activa' => 'bg-success',
                                    'cerrada' => 'bg-secondary',
                                    'cancelada' => 'bg-danger'
                                ][$r['estado_reserva']] ?? 'bg-warning text-dark';
                            ?>
                            <span class="badge <?= $badgeClass ?>">
                                <?= htmlspecialchars($r['estado_reserva']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="editar_reserva.php?id=<?= urlencode($r['id_reserva']) ?>" 
                               class="btn btn-sm btn-outline-primary">Editar</a>
                            <a href="../controlador/reservaControlador.php?accion=Eliminar&id=<?= urlencode($r['id_reserva']) ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Confirma eliminar esta reserva?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>