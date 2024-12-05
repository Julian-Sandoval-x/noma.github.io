<?php
require 'includes/config/database.php';
$db = conectarDB();

// Verificamos que el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreReserva = $_POST['nombreReserva'];
    $fechaReserva = $_POST['fechaReserva'];
    $totalPersonas = $_POST['totalPersonas'];
    $estado = $_POST['estado'];
    $zona = $_POST['zona'];

    // Preparamos la consulta SQL
    $query = "INSERT INTO reservaciones (nombreReserva, fechaReserva, totalPersonas, estado, zona) 
              VALUES ('$nombreReserva', '$fechaReserva', '$totalPersonas', '$estado', '$zona')";

    // Ejecutamos la consulta
    if (mysqli_query($db, $query)) {
        echo "Reservación agregada con éxito.";
        header('Location: index.php'); // Redirige a la página principal después de agregar
    } else {
        echo "Error al agregar la reservación: " . mysqli_error($db);
    }
}
