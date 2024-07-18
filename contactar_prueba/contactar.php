<?php
// Habilitar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Datos de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proepson_final_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$descripcion = $_POST['descripcion'];

// Validar los datos del formulario
if (empty($nombre) || empty($email) || empty($descripcion)) {
    die("Por favor, completa todos los campos requeridos.");
}

// Preparar la consulta SQL
$stmt = $conn->prepare("INSERT INTO contactos (nombre, email, descripcion) VALUES (?, ?, ?)");

if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("sss", $nombre, $email, $descripcion);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Nuevo registro creado con éxito";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>