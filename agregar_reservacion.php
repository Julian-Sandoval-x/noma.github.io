<?php
// Database connection
require 'includes/config/database.php';
$db = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $fecha = htmlspecialchars($_POST['fecha']);
    $total_personas = intval($_POST['total_personas']);
    $estado = "Pendiente";
    $zona = htmlspecialchars($_POST['zona']);

    $sql = "INSERT INTO reservaciones (estado, totalPersonas, fechaReserva, nombreReserva, zona) VALUES ('$estado', '$total_personas', '$fecha', '$nombre', '$zona')";

    if (mysqli_query($db, $sql)) {
        echo "Nueva reservación creada exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }

    $stmt->close();
}

$db->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Reservación</title>
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
    <h2>Agregar Nueva Reservación</h2>
    <form class="form-agregar" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
        </div>

        <div class="form-group">
            <label for="total_personas">Total de Personas:</label>
            <input type="number" id="total_personas" name="total_personas" required>
        </div>

        <div class="form-group">
            <label for="zona">Zona:</label>
            <select id="zona" name="zona" required>
                <option value="interior">Interior</option>
                <option value="exterior">Exterior</option>
            </select>
        </div>


        <input class="btn-agregar" type="submit" value="Agregar Reservación">
    </form>
</body>

</html>