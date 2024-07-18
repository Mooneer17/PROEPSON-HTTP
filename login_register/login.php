<?php
session_start();

$servername = "localhost";
$username = "root"; // Usualmente 'root' en XAMPP
$password = ""; // La contraseña por defecto en XAMPP es vacía
$dbname = "proepson_final_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Preparar y ejecutar la consulta
$stmt = $conn->prepare("SELECT id, nombre_usuario, contraseña FROM usuarios WHERE nombre_usuario = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Verificar si el usuario existe
if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $nombre_usuario, $hashed_password);
    $stmt->fetch();

    // Verificar la contraseña
    if (password_verify($password, $hashed_password)) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['userid'] = $id;
        $_SESSION['username'] = $nombre_usuario;
        echo "Inicio de sesión exitoso. Bienvenido, " . $nombre_usuario;
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta.";
    }
} else {
    // Usuario no encontrado
    echo "Usuario no encontrado.";
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>
