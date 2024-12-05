<?php
require 'includes/config/database.php';
$db = conectarDB();

$id = $_GET['id'];

$query = "SELECT id, nombre AS name, precio AS price, img FROM comida WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

echo json_encode($product);

$stmt->close();
$db->close();
