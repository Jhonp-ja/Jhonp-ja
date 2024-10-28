<?php
session_start();
include 'conexion.php'; // Incluir la conexión a la base de datos

// Procesamos las cantidades enviadas desde el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Actualizar cantidades
    if (isset($_POST['cantidad'])) {
        foreach ($_POST['cantidad'] as $id => $cantidad) {
            $sql = "SELECT nombre, precio FROM productos WHERE id = $id";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $producto = $result->fetch_assoc();
                if ($cantidad > 0) {
                    $_SESSION['carrito'][$id] = [
                        'nombre' => $producto['nombre'],
                        'precio' => $producto['precio'],
                        'cantidad' => $cantidad,
                    ];
                } else {
                    unset($_SESSION['carrito'][$id]); // Eliminar del carrito si cantidad es 0
                }
            }
        }
    }

    // Eliminar productos seleccionados
    if (isset($_POST['eliminar'])) {
        foreach ($_POST['eliminar'] as $id => $valor) {
            unset($_SESSION['carrito'][$id]); // Eliminar producto del carrito
        }
    }
}

// Mostrar el carrito
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5em; /* Aumentar tamaño del título */
            background-color: #007bff; /* Color de fondo */
            padding: 15px; /* Espaciado interno */
            border-radius: 5px; /* Bordes redondeados */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Sombra */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px; /* Bordes redondeados */
            overflow: hidden; /* Esconde bordes sobresalientes */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s; /* Transición al cambiar el borde */
        }

        input[type="number"]:focus {
            border-color: #007bff; /* Cambio de color al enfocar */
            outline: none; /* Eliminar el borde predeterminado */
        }

        input[type="submit"], a {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s; /* Transición al pasar el ratón */
        }

        input[type="submit"]:hover, a:hover {
            background-color: #0056b3;
            transform: scale(1.05); /* Efecto de aumento al pasar el ratón */
        }

        .total {
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 20px;
            text-align: center; /* Centrar el total */
            color: #007bff; /* Color azul */
        }

        .empty-cart {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2em;
            color: #555;
        }

        .button-container {
            text-align: center; /* Centrar botones */
            margin-top: 20px; /* Espacio superior */
        }

        .button-container a {
            margin-left: 10px; /* Espacio entre enlaces */
        }
    </style>
</head>
<body>

<?php if (!empty($_SESSION['carrito'])): ?>
    <h1>Carrito de compras</h1>
    <form action='carrito.php' method='POST'>
        <table>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Eliminar</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['carrito'] as $id => $producto) {
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $total += $subtotal;
                echo "<tr>
                    <td>{$producto['nombre']}</td>
                    <td>\${$producto['precio']}</td>
                    <td>
                        <input type='number' name='cantidad[$id]' min='0' value='{$producto['cantidad']}'>
                    </td>
                    <td>\$".number_format($subtotal, 2)."</td>
                    <td>
                        <input type='checkbox' name='eliminar[$id]' value='1'> Eliminar
                    </td>
                </tr>";
            }
            ?>
        </table>
        <div class='total'>Total a pagar💀: \$<?php echo number_format($total, 2); ?></div>
        <input type='submit' value='Actualizar Carrito'>
    </form>
    <div class="button-container">
        <a href="procesar_venta.php">❤️Haz tu pago aquí te amamos❤️</a>
        <br>
        <a href="index.php">Volver a elegir productos</a> <!-- Enlace para volver a elegir productos -->
    </div>
<?php else: ?>
    <div class="empty-cart">
        <p>No hay productos en el carrito.</p>
        <a href="index.php">Volver a elegir productos😊</a> <!-- Enlace para volver a elegir productos -->
    </div>
<?php endif; ?>

</body>
</html>
