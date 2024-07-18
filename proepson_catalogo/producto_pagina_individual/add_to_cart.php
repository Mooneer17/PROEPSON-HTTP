<?php
header('Content-Type: application/json');

// Parámetros de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Sin contraseña en este caso
$database = "proepson_final_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Obtener los datos del producto del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);
if ($data === null) {
    echo json_encode(["error" => "Invalid JSON"]);
    exit;
}

$productId = $data['id'] ?? null;
$nombre = $data['nombre'] ?? null;
$precio = $data['precio'] ?? null;
$cantidad = $data['cantidad'] ?? 1;

if ($productId === null || $nombre === null || $precio === null) {
    echo json_encode(["error" => "Missing product data"]);
    exit;
}

// Insertar en la tabla carrito
$stmt = $conn->prepare("INSERT INTO carrito (producto_id, nombre, precio, cantidad) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    exit;
}

$stmt->bind_param("isdi", $productId, $nombre, $precio, $cantidad);

if ($stmt->execute()) {
    echo json_encode(["success" => "Product added to cart"]);
} else {
    echo json_encode(["error" => "Failed to add product to cart: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
