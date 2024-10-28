<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redirigir a la página de login
    exit;
}

// Incluir la conexión a la base de datos
include 'conexion.php'; // Asegúrate de que la ruta sea correcta

// Habilitar la visualización de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si la conexión fue exitosa
if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta para obtener productos de la base de datos
$sql = "SELECT id, nombre, precio FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productosTable').DataTable({
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
            color: #333;
            text-align: center;
            animation: fadeIn 1s;
            display: flex;
            align-items: center; 
            justify-content: center; 
        }

        h1 img {
            width: 120px; 
            height: auto; 
            margin-right: 40px; 
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s;
            border-radius: 8px; /* Bordes redondeados */
            overflow: hidden; /* Para redondear las esquinas del contenedor */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase; /* Texto en mayúsculas */
            letter-spacing: 1px; /* Espaciado entre letras */
        }

        tr:hover {
            background-color: #e9ecef; /* Color de fondo al pasar el ratón */
        }

        td {
            background-color: #f8f9fa; /* Color de fondo de las celdas */
        }

        td select {
            padding: 5px;
            border: 1px solid #007bff; /* Borde del selector */
            border-radius: 4px; /* Bordes redondeados */
            outline: none; /* Sin contorno al hacer clic */
        }

        td select:focus {
            border-color: #0056b3; /* Color del borde al enfocar */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Sombra al enfocar */
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545; /* Color rojo */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
            margin-left: 10px; /* Espacio entre los botones */
        }

        .logout-btn:hover {
            background-color: #c82333; /* Color más oscuro al pasar el ratón */
            transform: scale(1.05); /* Aumentar ligeramente el tamaño */
        }

        .button-container {
            text-align: center;
            margin-top: 20px; /* Espacio superior */
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

    <h1>
        <img src="https://img.freepik.com/vector-premium/icono-tienda-blanco-negro_755164-15634.jpg" alt="Imagen de la tienda">
        Lista de productos
    </h1>

    <form action="carrito.php" method="POST">
        <table id="productosTable" border="1">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($producto = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo '$' . number_format($producto['precio'], 2); ?></td>
                        <td>
                            <select name="cantidad[<?php echo $producto['id']; ?>]">
                                <option value="0">Selecciona la cantidad</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <br>
        <div class="button-container">
            <input type="submit" value="Agregar al carrito">
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>
    </form>
</body>
</html>
