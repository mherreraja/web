<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once '../modelo/HabitacionDAO.php';
$dao = new HabitacionDAO();
$habitacion = null;

if (isset($_GET['id'])) {
    $habitacion = $dao->buscar($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $habitacion ? 'Editar' : 'Crear' ?> Habitación</title>
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
            max-width: 500px; 
            margin: 20px auto; 
            background: white; 
            padding: 30px; 
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header><?= $habitacion ? 'Editar' : 'Crear' ?> Habitación</header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="habitaciones.php">Habitaciones</a>
        <a href="reservas.php">Reservas</a>
        <a href="clientes.php">Clientes</a>
        <a href="../controlador/usuarioControlador.php?accion=Logout">Salir</a>
    </nav>
    
    <div class="container">
        <a href="habitaciones.php" class="btn btn-secondary mb-3">← Volver a Habitaciones</a>
        
        <div class="form-container">
            <h2 class="text-center mb-4"><?= $habitacion ? 'Editar' : 'Crear' ?> Habitación</h2>
            <form method="post" action="../controlador/habitacionControlador.php">
                <input type="hidden" name="accion" value="<?= $habitacion ? 'Actualizar' : 'Registrar' ?>">
                
                <div class="mb-3">
                    <label class="form-label">ID Habitación:</label>
                    <input type="text" class="form-control" name="id_habitacion" value="<?= $habitacion ? htmlspecialchars($habitacion['id_habitacion']) : '' ?>" <?= $habitacion ? 'readonly' : '' ?> required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Número:</label>
                    <input type="text" class="form-control" name="numero" value="<?= $habitacion ? htmlspecialchars($habitacion['numero']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Tipo:</label>
                    <select class="form-select" name="tipo" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="Single" <?= $habitacion && $habitacion['tipo'] == 'Single' ? 'selected' : '' ?>>Single</option>
                        <option value="Doble" <?= $habitacion && $habitacion['tipo'] == 'Doble' ? 'selected' : '' ?>>Doble</option>
                        <option value="Suite" <?= $habitacion && $habitacion['tipo'] == 'Suite' ? 'selected' : '' ?>>Suite</option>
                        <option value="Familiar" <?= $habitacion && $habitacion['tipo'] == 'Familiar' ? 'selected' : '' ?>>Familiar</option>
                        <option value="Presidencial" <?= $habitacion && $habitacion['tipo'] == 'Presidencial' ? 'selected' : '' ?>>Presidencial</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Precio por Noche:</label>
                    <input type="number" step="0.01" class="form-control" name="precio_noche" value="<?= $habitacion ? htmlspecialchars($habitacion['precio_noche']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Estado:</label>
                    <select class="form-select" name="estado_habitacion" required>
                        <option value="libre" <?= $habitacion && $habitacion['estado_habitacion'] == 'libre' ? 'selected' : '' ?>>Libre</option>
                        <option value="ocupada" <?= $habitacion && $habitacion['estado_habitacion'] == 'ocupada' ? 'selected' : '' ?>>Ocupada</option>
                        <option value="mantenimiento" <?= $habitacion && $habitacion['estado_habitacion'] == 'mantenimiento' ? 'selected' : '' ?>>Mantenimiento</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary w-100"><?= $habitacion ? 'Actualizar' : 'Registrar' ?> Habitación</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>