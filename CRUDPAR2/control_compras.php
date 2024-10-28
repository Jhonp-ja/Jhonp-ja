<?php
session_start();
include 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'admin') {
    header("Location: login.php"); // Redirigir a la página de login si no es admin
    exit;
}

// Consulta para obtener todas las ventas
$sql = "SELECT v.id, v.producto_id, v.cantidad, v.total, v.fecha, p.nombre 
        FROM ventas v 
        JOIN productos p ON v.producto_id = p.id 
        ORDER BY v.fecha DESC";
$result = $conn->query($sql);

// Consulta para obtener el total acumulado de las ventas
$totalAcumulado = 0;
$totalQuery = "SELECT SUM(total) AS total FROM ventas";
$totalResult = $conn->query($totalQuery);

if ($totalResult && $totalRow = $totalResult->fetch_assoc()) {
    $totalAcumulado = $totalRow['total'] ? $totalRow['total'] : 0; // Asegurarse de que no sea null
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Compras</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#comprasTable').DataTable({
                language: {
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay entradas disponibles",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });

            // Agregar la imagen de lupa al campo de búsqueda
            $('.dataTables_filter label').prepend('<img src="https://img.icons8.com/ios-filled/20/000000/search.png" class="search-icon" alt="Buscar">');
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff; /* Color del texto */
            font-size: 2.5em; /* Tamaño del texto */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3); /* Sombra de texto */
            margin-bottom: 20px; /* Espacio debajo del título */
            padding: 10px; /* Espaciado interno */
            border-radius: 8px; /* Bordes redondeados */
            background: linear-gradient(135deg, #007bff, #00c6ff); /* Degradado de fondo */
            display: inline-block; /* Ajuste al contenido */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .total {
            text-align: center;
            margin-top: 20px;
            font-size: 1.5em;
            font-weight: bold;
            padding: 20px; /* Espaciado dentro del cuadrado */
            background-color: #ffffff; /* Fondo blanco */
            border: 2px solid #007bff; /* Borde azul */
            border-radius: 8px; /* Bordes redondeados */
            display: inline-block; /* Para que se ajuste al contenido */
        }

        .btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3; /* Color más oscuro al pasar el ratón */
        }

        .logout-btn {
            background-color: #dc3545; /* Color rojo para el botón de salir */
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #c82333; /* Color más oscuro al pasar el ratón */
        }

        .dataTables_filter {
            position: relative;
            margin-bottom: 20px; /* Espacio debajo del campo de búsqueda */
        }

        .search-icon {
            position: absolute;
            left: -30px;
            top: 5px; /* Ajusta la posición vertical de la lupa */
            width: 20px; /* Ajusta el tamaño de la imagen */
            height: 20px; /* Ajusta el tamaño de la imagen */
        }

        .dataTables_filter input {
            padding-left: 30px; /* Espacio para la imagen */
            border: 1px solid #ddd; /* Borde del campo de búsqueda */
            border-radius: 5px; /* Bordes redondeados */
            font-size: 16px; /* Tamaño de fuente */
        }

        .dataTables_length, .dataTables_paginate {
            margin: 20px 0; /* Espacio superior e inferior */
            text-align: center; /* Centrar los elementos */
        }

        .dataTables_length select {
            padding: 5px;
            border: 1px solid #ddd; /* Borde del selector */
            border-radius: 5px; /* Bordes redondeados */
            font-size: 16px; /* Tamaño de fuente */
        }

        .dataTables_paginate a {
            padding: 10px 15px; /* Espacio interno */
            border: 1px solid #007bff; /* Borde de los botones */
            border-radius: 5px; /* Bordes redondeados */
            color: #007bff; /* Color del texto */
            margin: 0 5px; /* Margen entre botones */
            text-decoration: none; /* Sin subrayado */
        }

        .dataTables_paginate a:hover {
            background-color: #007bff; /* Color de fondo al pasar el ratón */
            color: white; /* Color del texto al pasar el ratón */
        }
    </style>
</head>
<body>
    <h1>Control de Compras</h1>
    <table id="comprasTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($venta = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $venta['id']; ?></td>
                        <td><?php echo htmlspecialchars($venta['nombre']); ?></td>
                        <td><?php echo $venta['cantidad']; ?></td>
                        <td><?php echo '$' . number_format($venta['total'], 2); ?></td>
                        <td><?php echo $venta['fecha']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay compras registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="total">
        Total Acumulado de Ventas: $<?php echo number_format($totalAcumulado, 2); ?>
    </div>

    <div class="button-container" style="text-align: center;">
       
        <a href="inventario.php" class="btn">Ver Inventario en Stock</a>
        <a href="logout.php" class="btn logout-btn">Salir</a> <!-- Botón de salir -->
    </div>
</body>
</html>
