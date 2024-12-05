<?php
require 'includes/config/database.php';
$db = conectarDB();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM reservaciones WHERE id = $id";
    $resultado = mysqli_query($db, $query);

    if ($resultado) {
        echo "Reservación eliminada correctamente.";
    } else {
        echo "Error al eliminar la reservación.";
    }

    // Redirige a la página principal de reservaciones
    header('Location: reservaciones.php');
    exit;
}
