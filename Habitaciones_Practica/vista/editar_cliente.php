<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

require_once '../modelo/ClienteDAO.php';
$dao = new ClienteDAO();
$cliente = null;

if (isset($_GET['id'])) {
    $cliente = $dao->buscar($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $cliente ? 'Editar' : 'Crear' ?> Cliente</title>
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
    <header><?= $cliente ? 'Editar' : 'Crear' ?> Cliente</header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="habitaciones.php">Habitaciones</a>
        <a href="reservas.php">Reservas</a>
        <a href="clientes.php">Clientes</a>
        <a href="../controlador/usuarioControlador.php?accion=Logout">Salir</a>
    </nav>
    
    <div class="container">
        <a href="clientes.php" class="btn btn-secondary mb-3">← Volver a Clientes</a>
        
        <div class="form-container">
            <h2 class="text-center mb-4"><?= $cliente ? 'Editar' : 'Crear' ?> Cliente</h2>
            <form method="post" action="../controlador/clienteControlador.php">
                <input type="hidden" name="accion" value="<?= $cliente ? 'Actualizar' : 'Registrar' ?>">
                
                <div class="mb-3">
                    <label class="form-label">ID Cliente:</label>
                    <input type="text" class="form-control" name="id_cliente" value="<?= $cliente ? htmlspecialchars($cliente['id_cliente']) : '' ?>" <?= $cliente ? 'readonly' : '' ?> required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">DNI:</label>
                    <input type="text" class="form-control" name="dni" value="<?= $cliente ? htmlspecialchars($cliente['dni']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Nombre Completo:</label>
                    <input type="text" class="form-control" name="nombre_completo" value="<?= $cliente ? htmlspecialchars($cliente['nombre_completo']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" name="telefono" value="<?= $cliente ? htmlspecialchars($cliente['telefono']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Correo:</label>
                    <input type="email" class="form-control" name="correo" value="<?= $cliente ? htmlspecialchars($cliente['correo']) : '' ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Estado:</label>
                    <select class="form-select" name="estado" required>
                        <option value="activo" <?= $cliente && $cliente['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="inactivo" <?= $cliente && $cliente['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary w-100"><?= $cliente ? 'Actualizar' : 'Registrar' ?> Cliente</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>