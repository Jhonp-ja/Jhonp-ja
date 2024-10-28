<?php
session_start();
include 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si ya está logueado
if (isset($_SESSION['usuario'])) {
    header("Location: index.php"); // Redirigir si ya está logueado
    exit;
}

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar en la base de datos
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario['username'];
            $_SESSION['rol'] = $usuario['rol']; // Guardar el rol

            // Redirigir según el rol
            if ($usuario['rol'] != 'administrador') {
                header("Location: control_compras.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://img.freepik.com/premium-photo/shopping-cart-with-shopping-cart-front-it_878763-783.jpg'); /* Cambia esta URL a tu imagen deseada */
            background-size: cover; /* Asegura que la imagen cubra toda la pantalla sin distorsión */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            background-position: center; /* Centra la imagen en la pantalla */
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            background: rgba(255, 255, 255, 0.9); /* Fondo blanco semi-transparente */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <div class="login-container">
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" name="username" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <label for="rol">Rol:</label>
            <select name="rol" required>
                <option value="cliente">Cliente</option>
                <option value="administrador">Administrador</option>
            </select>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>
