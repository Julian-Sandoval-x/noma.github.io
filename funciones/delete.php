<?php
require 'includes/config/database.php';
$db = conectarDB();

// Verificamos que el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombreReserva = $_POST['nombreReserva'];
    $fechaReserva = $_POST['fechaReserva'];
    $totalPersonas = $_POST['totalPersonas'];
    $estado = $_POST['estado'];
    $zona = $_POST['zona'];

    // Preparamos la consulta SQL para actualizar
    $query = "UPDATE reservaciones SET nombreReserva = '$nombreReserva', fechaReserva = '$fechaReserva', 
              totalPersonas = '$totalPersonas', estado = '$estado', zona = '$zona' WHERE id = $id";

    // Ejecutamos la consulta
    if (mysqli_query($db, $query)) {
        echo "Reservación actualizada con éxito.";
        header('Location: index.php'); // Redirige a la página principal después de actualizar
    } else {
        echo "Error al modificar la reservación: " . mysqli_error($db);
    }
}
