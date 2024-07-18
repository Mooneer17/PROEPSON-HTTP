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

// Verificar si el parámetro 'id' está definido en la URL
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Preparar la consulta SQL
    $stmt = $conn->prepare("SELECT * FROM producto WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró el producto
        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            echo json_encode($producto);
        } else {
            echo json_encode(null); // No se encontró el producto
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid product ID."]);
}

$conn->close();
?>
