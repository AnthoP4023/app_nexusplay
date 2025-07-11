<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (isLoggedIn()) {
    header('Location: ../index.php');
    exit();
}

$error = '';

if ($_POST) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();
        
        // CAMBIO PRINCIPAL: Usar md5() en lugar de password_verify()
        if ($user && md5($password) === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['tipo_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['apellido'] = $user['apellido']; // Agregado para tener el nombre completo
            
            header('Location: ../index.php');
            exit();
        } else {
            $error = 'Usuario o contraseña incorrectos';
        }
    } else {
        $error = 'Completa todos los campos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NexusPlay</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <!-- IZQUIERDA - LOGO Y LOGIN -->
        <div class="left-side">
            <!-- SECCIÓN DEL LOGO -->
            <div class="logo-section">
                <a href="../index.php" class="logo-top">
                    <img src="../images/logo.png" alt="Logo">
                    <span>NexusPlay</span>
                </a>
            </div>
            
            <!-- SECCIÓN DEL LOGIN -->
            <div class="login-section">
                <div class="form-center">
                    <h2>Iniciar Sesión</h2>
                    <?php if ($error): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <input type="text" name="username" placeholder="👤 Usuario o Email" required>
                        <input type="password" name="password" placeholder="🔒 Contraseña" required>
                        <button type="submit">Iniciar Sesión</button>
                    </form>
                    <div class="links">
                        <a href="register.php">¿No tienes cuenta? Regístrate</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- DERECHA - IMAGEN -->
        <div class="right-side">
            <a href="../index.php" class="close-btn">
                <span>&times;</span>
            </a>
            <img src="../images/imagen1.jpg" alt="Gaming">
        </div>
    </div>
</body>
</html>