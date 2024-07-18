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

// Consulta de categorías
$query = "SELECT * FROM categorias";

$result = $conn->query($query);

$categorias = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}

// Devolver categorías como JSON
echo json_encode($categorias);

// Cerrar conexión
$conn->close();
?>
