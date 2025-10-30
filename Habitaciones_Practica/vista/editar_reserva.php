<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once '../modelo/ReservaDAO.php';
require_once '../modelo/HabitacionDAO.php';
require_once '../modelo/ClienteDAO.php';

$reservaDAO = new ReservaDAO();
$habitacionDAO = new HabitacionDAO();
$clienteDAO = new ClienteDAO();

$reserva = null;
$habitaciones = $habitacionDAO->listar();
$clientes = $clienteDAO->listar();

if (isset($_GET['id'])) {
    $reserva = $reservaDAO->buscar($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $reserva ? 'Editar' : 'Crear' ?> Reserva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏨</text></svg>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f5f1e9; 
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
        .form-container { 
            max-width: 600px; 
            margin: 20px auto; 
            background: white; 
            padding: 30px; 
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header><?= $reserva ? 'Editar' : 'Crear' ?> Reserva</header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="habitaciones.php">Habitaciones</a>
        <a href="reservas.php">Reservas</a>
        <a href="clientes.php">Clientes</a>
        <a href="../controlador/usuarioControlador.php?accion=Logout">Salir</a>
    </nav>
    
    <div class="container">
        <a href="reservas.php" class="btn btn-secondary mb-3">← Volver a Reservas</a>
        
        <div class="form-container">
            <h2 class="text-center mb-4"><?= $reserva ? 'Editar' : 'Crear' ?> Reserva</h2>
            
            <?php if(!$reserva): ?>
            <div class="alert alert-info">
                <strong>💡 Información:</strong> El monto total se calculará automáticamente basado en el precio de la habitación y número de noches.
            </div>
            <?php endif; ?>
            
            <form method="post" action="../controlador/reservaControlador.php">
                <input type="hidden" name="accion" value="<?= $reserva ? 'Actualizar' : 'Registrar' ?>">
                
                <div class="mb-3">
                    <label class="form-label">ID Reserva:</label>
                    <input type="text" class="form-control" name="id_reserva" value="<?= $reserva ? htmlspecialchars($reserva['id_reserva']) : '' ?>" <?= $reserva ? 'readonly' : '' ?> required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Habitación:</label>
                    <select class="form-select" name="habitacion_id" required>
                        <option value="">Seleccionar habitación</option>
                        <?php foreach($habitaciones as $h): ?>
                            <option value="<?= $h['id_habitacion'] ?>" 
                                <?= $reserva && $reserva['habitacion_id'] == $h['id_habitacion'] ? 'selected' : '' ?>
                                data-precio="<?= $h['precio_noche'] ?>">
                                <?= $h['numero'] ?> - <?= $h['tipo'] ?> (S/.<?= $h['precio_noche'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Cliente:</label>
                    <select class="form-select" name="cliente_id" required>
                        <option value="">Seleccionar cliente</option>
                        <?php foreach($clientes as $c): ?>
                            <option value="<?= $c['id_cliente'] ?>" 
                                <?= $reserva && $reserva['cliente_id'] == $c['id_cliente'] ? 'selected' : '' ?>>
                                <?= $c['nombre_completo'] ?> - <?= $c['dni'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Fecha Ingreso:</label>
                    <input type="date" class="form-control" name="fecha_ingreso" value="<?= $reserva ? htmlspecialchars($reserva['fecha_ingreso']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Fecha Salida:</label>
                    <input type="date" class="form-control" name="fecha_salida" value="<?= $reserva ? htmlspecialchars($reserva['fecha_salida']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Noches:</label>
                    <input type="number" class="form-control" name="noches" value="<?= $reserva ? htmlspecialchars($reserva['noches']) : '' ?>" min="1" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Estado de Reserva:</label>
                    <select class="form-select" name="estado_reserva" required>
                        <option value="activa" <?= $reserva && $reserva['estado_reserva'] == 'activa' ? 'selected' : '' ?>>Activa</option>
                        <option value="cerrada" <?= $reserva && $reserva['estado_reserva'] == 'cerrada' ? 'selected' : '' ?>>Cerrada</option>
                        <option value="cancelada" <?= $reserva && $reserva['estado_reserva'] == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary w-100"><?= $reserva ? 'Actualizar' : 'Registrar' ?> Reserva</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaIngreso = document.querySelector('input[name="fecha_ingreso"]');
            const fechaSalida = document.querySelector('input[name="fecha_salida"]');
            const nochesInput = document.querySelector('input[name="noches"]');
            
            function calcularNoches() {
                if (fechaIngreso.value && fechaSalida.value) {
                    const ingreso = new Date(fechaIngreso.value);
                    const salida = new Date(fechaSalida.value);
                    const diffTime = salida - ingreso;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    
                    if (diffDays > 0) {
                        nochesInput.value = diffDays;
                    }
                }
            }
            
            fechaIngreso.addEventListener('change', calcularNoches);
            fechaSalida.addEventListener('change', calcularNoches);
        });
    </script>
</body>
</html>