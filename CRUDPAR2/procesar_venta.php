<?php
session_start();
include 'conexion.php'; // Incluir la conexión a la base de datos

// Consulta para obtener el total acumulado de las ventas
$totalAcumulado = 0;
$totalQuery = "SELECT SUM(total) AS total FROM ventas";
$totalResult = $conn->query($totalQuery);

if ($totalResult && $totalRow = $totalResult->fetch_assoc()) {
    $totalAcumulado = $totalRow['total'] ? $totalRow['total'] : 0; // Asegurarse de que no sea null
}

if (!empty($_SESSION['carrito'])) {
    // Procesar la venta e insertar los datos en la tabla 'ventas'
    foreach ($_SESSION['carrito'] as $id => $producto) {
        $sql = "INSERT INTO ventas (producto_id, cantidad, total) VALUES ($id, {$producto['cantidad']}, {$producto['precio']} * {$producto['cantidad']})";
        $conn->query($sql);
    }
    
    // Limpiamos el carrito después de procesar la venta
    unset($_SESSION['carrito']);
    $mensaje = "<h1>¡Gracias por tu compra!</h1><p>La venta ha sido procesada con éxito.</p>";
} else {
    $mensaje = "<p>No hay productos en el carrito para procesar.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito en Movimiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
            overflow: hidden;
        }

        .cart-container {
            background: gray;
            padding: 30px;
            border-radius: 2px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .cart-icon {
            width: 100px;
            height: 100px;
            position: absolute;
            bottom: 0;
            animation: move 5s linear infinite;
        }

        @keyframes move {
            0% { left: -120px; }
            100% { left: 100vw; }
        }

        h1, p {
            position: relative;
            z-index: 1;
            margin-bottom: 120px;
        }

        .exit-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .exit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <img src="https://img.icons8.com/ios/100/000000/shopping-cart.png" alt="Carrito" class="cart-icon">
        <?php echo $mensaje; ?>
        <br>
        
        <a href="login.php" class="exit-button">volver a la tienda para realizar mas compras ya que eres rico</a>
    </div>
</body>
</html>
