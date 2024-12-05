<?php

// Accedemos a la base de datos
require 'includes/config/database.php';
$db = conectarDB();

// Realizamos la consulta para obtener las reservaciones
$query = "SELECT id, nombreReserva, fechaReserva, totalPersonas, estado, zona FROM reservaciones";
$resultado = mysqli_query($db, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <title>Reservaciones</title>
</head>

<body>
    <div class="title">
        <h1>Reservaciones</h1>
    </div>
    <nav class="nav">
        <a href="index.html">Inicio</a>
        <a href="menu.html">Menu</a>
        <a href="index.html">Contact</a>
    </nav>

    <table class="reservacion">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Total de Personas</th>
                <th>Estado</th>
                <th>Zona</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombreReserva']); ?></td>
                    <td><?php echo htmlspecialchars($row['fechaReserva']); ?></td>
                    <td><?php echo htmlspecialchars($row['totalPersonas']); ?></td>
                    <td><?php echo htmlspecialchars($row['estado']); ?></td>
                    <td><?php echo htmlspecialchars($row['zona']); ?></td>
                    <td>

                        <div class="actions">
                            <!-- Botón de modificar -->
                            <a class="btn-actions update" href="modificar_reservacion.php?id=<?php echo $row['id'] ?>">Modificar</a>
                            <!-- Botón de eliminar -->
                            <form class="btn-actions" method="POST" action="eliminar_reservacion.php" id="deleteForm">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="button" class="delete" value="Eliminar">
                            </form>
                        </div>


                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Botón de agregar -->

    <a href="agregar_reservacion.php" class="btn-agregar">Agregar Reservación</a>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="build/js/app.js"></script>

</body>

</html>