<?php
session_start();
include 'conexion.php'; // Incluir la conexión a la base de datos

// Verificar si el usuario es cliente
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php"); // Redirigir a la página de login si no es cliente
    exit;
}

// Consulta para obtener todos los productos del inventario
$sql = "SELECT * FROM inventario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inventarioTable').DataTable({
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

        .btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #dc3545; /* Rojo */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #c82333; /* Color más oscuro al pasar el ratón */
        }

        .dataTables_filter {
            position: relative;
            margin-bottom: 20px; /* Espacio debajo del campo de búsqueda */
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
    </style>
</head>
<body>
    <h1>Inventario de Productos</h1>
    <table id="inventarioTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($producto = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo $producto['stock']; ?></td>
                        <td><?php echo '$' . number_format($producto['precio'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay productos en el inventario.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="logout.php" class="btn">Salir</a>
</body>
</html>
