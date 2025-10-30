<?php session_start(); 
if(isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HotelReservas - Sistema de Gestión Hotelera</title>
    <meta name="description" content="Sistema profesional de gestión de reservas hoteleras">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏨</text></svg>">
    <style>
        body {
            background: linear-gradient(135deg, #f5f1e9 0%, #dabe99 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-header {
            background: #dabe99;
            color: #3e2f1c;
            padding: 2rem;
            text-align: center;
        }
        .btn-hotel {
            background: #a58940;
            border: none;
            color: white;
            padding: 12px;
        }
        .btn-hotel:hover {
            background: #7c6830;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-container">
                    <div class="login-header">
                        <h2>🏨 HotelReservas</h2>
                        <p class="mb-0">Sistema de Gestión Hotelera</p>
                    </div>
                    <div class="p-4">
                        <form method="post" action="../controlador/usuarioControlador.php">
                            <input type="hidden" name="accion" value="Login">
                            
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="admin@hotel.com" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="clave" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="clave" name="clave" placeholder="123456" required>
                            </div>
                            
                            <button type="submit" class="btn btn-hotel w-100">Entrar al Sistema</button>
                        </form>
                        
                        <?php if(isset($_SESSION['error_login'])): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?= $_SESSION['error_login'] ?>
                            </div>
                            <?php unset($_SESSION['error_login']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>