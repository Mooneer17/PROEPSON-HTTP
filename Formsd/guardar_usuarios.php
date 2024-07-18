<?php
    // Obtener los datos enviados desde JavaScript
    $usuarios = json_decode(file_get_contents('php://input'), true);

    // Guardar los datos en el archivo JSON
    file_put_contents('usuarios.json', json_encode($usuarios));

    // Enviar respuesta exitosa (código 200)
    http_response_code(200);
?>
