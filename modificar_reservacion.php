<?php

// Conexión con la base de datos
require 'includes/config/database.php';
$db = conectarDB();

$id = $_GET['id'];

// Validación del ID y manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación del ID
    if (!isset($_POST['id']) || !filter_var($_POST['id'], FILTER_VALIDATE_INT)) {
        echo "ID no válido";
        exit;
    }

    $id = (int) $_POST['id'];
    $nombreReserva = $_POST['nombreReserva'] ?? null;
    $fechaReserva = $_POST['fechaReserva'] ?? null;
    $totalPersonas = intval($_POST['totalPersonas']) ?? null;
    $estado = $_POST['estado'] ?? null;

    // Validar que los campos no estén vacíos
    if (!$nombreReserva || !$fechaReserva || !$totalPersonas || !$estado) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    $query = "UPDATE reservaciones SET nombreReserva = '$nombreReserva', fechaReserva = '$fechaReserva', totalPersonas = '$totalPersonas', estado = '$estado' WHERE id = $id";

    if (mysqli_query($db, $query)) {
        header("Location: reservaciones.php");
    }
} else {
    // Consulta segura utilizando prepared statements
    $query = "SELECT * FROM reservaciones WHERE id = {$id}";
    $result = mysqli_query($db, $query);
    $reservacion = mysqli_fetch_assoc($result);

    // Verificación del resultado
    if (!$reservacion) {
        echo "Reservación no encontrada.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <title>Modificar Reservaciones</title>
</head>

<body>
    <!-- Formulario para modificar la reservación -->
    <form action="modificar_reservacion.php" method="POST" class="form-modificar">
        <h2>Modificar Reservación</h2>

        <input type="hidden" name="id" value="<?php echo $reservacion['id']; ?>">

        <div class="form-group">
            <label for="nombreReserva">Nombre de la Reservación</label>
            <input type="text" id="nombreReserva" name="nombreReserva" value="<?php echo $reservacion['nombreReserva']; ?>" required>
        </div>

        <div class="form-group">
            <label for="fechaReserva">Fecha de la Reservación</label>
            <input type="date" id="fechaReserva" name="fechaReserva" value="<?php echo $reservacion['fechaReserva']; ?>" required>
        </div>

        <div class="form-group">
            <label for="totalPersonas">Total de Personas</label>
            <input type="number" id="totalPersonas" name="totalPersonas" value="<?php echo $reservacion['totalPersonas']; ?>" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <option value="confirmada" <?php echo ($reservacion['estado'] === 'confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                <option value="pendiente" <?php echo ($reservacion['estado'] === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                <option value="cancelada" <?php echo ($reservacion['estado'] === 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="zona">Zona</label>
            <select id="zona" name="zona" required>
                <option value="interior" <?php echo ($reservacion['zona'] === 'interior') ? 'selected' : ''; ?>>Interior</option>
                <option value="exterior" <?php echo ($reservacion['zona'] === 'exterior') ? 'selected' : ''; ?>>Exterior</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Guardar Cambios</button>
            <a href="reservaciones.php" class="btn-regresar">Regresar</a>
        </div>
    </form>
</body>

</html>