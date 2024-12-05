<?php
require 'includes/config/database.php';
$db = conectarDB();

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $total = 0;
    foreach ($data as $item) {
        $total += $item['subtotal'];
    }

    // Generar un folio aleatorio de 10 caracteres
    $folio = bin2hex(random_bytes(5));

    $query = "INSERT INTO ventas (folio, total) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sd", $folio, $total);
    $stmt->execute();
    $venta_id = $stmt->insert_id;

    foreach ($data as $item) {
        $query = "INSERT INTO ventas_detalle (venta_id, producto_id, cantidad, subtotal) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iiid", $venta_id, $item['id'], $item['quantity'], $item['subtotal']);
        $stmt->execute();
    }

    $stmt->close();
    $db->close();

    echo json_encode(['success' => true, 'folio' => $folio]);
} else {
    echo json_encode(['success' => false]);
}
