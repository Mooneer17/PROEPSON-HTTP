<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Sin contraseña en este caso
$database = "proepson_final_db";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categoria_id = $_GET['categoria_id'] ?? '';

// Consulta de productos basada en la categoría
if ($categoria_id) {
    $query = "SELECT * FROM producto WHERE categoria_id = '$categoria_id'";
} else {
    $query = "SELECT * FROM producto";
}

$result = $conn->query($query);

$productos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Devolver productos como JSON
header('Content-Type: application/json');
echo json_encode($productos);

// Cerrar conexión
$conn->close();
?>
