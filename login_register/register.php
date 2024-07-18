<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // La contraseña por defecto en XAMPP es vacía
$dbname = "proepson_final_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre_usuario = $_POST['username'];
$email = $_POST['email'];
$contraseña = $_POST['password'];
$confirmar_contraseña = $_POST['confirm-password'];

// Verificar si las contraseñas coinciden
if ($contraseña !== $confirmar_contraseña) {
    die("Las contraseñas no coinciden.");
}

// Encriptar la contraseña
$hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);

// Preparar y ejecutar la consulta
$stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, contraseña) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre_usuario, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Registro exitoso. Puedes iniciar sesión ahora.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>
