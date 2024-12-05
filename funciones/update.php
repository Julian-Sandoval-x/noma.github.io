<?php

// Obtenemos el ID de la reservación
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: ../../../../../reservaciones.php');
}

// Obtenemos los datos de la reservación
$query = "SELECT nombreReserva, fechaReserva, totalPersonas, estado, zona FROM reservaciones WHERE id = {$id}";
$resultado = mysqli_query($db, $query);
$data = mysqli_fetch_assoc($resultado);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $nombreReserva = $_POST['nombreReserva'];
    $fechaReserva = $_POST['fechaReserva'];
    $totalPersonas = $_POST['totalPersonas'];
    $estado = $_POST['estado'];
    $zona = $_POST['zona'];

    // ID de la reservación (por ejemplo, pasarlo como parámetro GET)
    $idReservacion = $_GET['id'];

    // Preparar la consulta SQL para actualizar la reservación
    $query = "UPDATE reservaciones 
              SET nombreReserva = ?, fechaReserva = ?, totalPersonas = ?, estado = ?, zona = ?
              WHERE id = ?";

    // Preparar la sentencia
    $stmt = $db->prepare($query);

    // Vincular los parámetros
    $stmt->bind_param('sssssi', $nombreReserva, $fechaReserva, $totalPersonas, $estado, $zona, $idReservacion);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        echo "Reservación actualizada con éxito.";
        // Redirigir a la lista de reservaciones o alguna otra página
        header("Location: reservaciones.php");
    } else {
        echo "Error al actualizar la reservación.";
    }

    // Cerrar la conexión
    $stmt->close();
    $db->close();
}
