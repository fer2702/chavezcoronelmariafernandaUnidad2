<?php
// guardar.php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seguridad_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión"]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$nombre = $conn->real_escape_string($data['nombre'] ?? '');
$email = $conn->real_escape_string($data['email'] ?? '');

if (!$nombre || !$email) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$sql = "INSERT INTO us (nombre, email) VALUES ('$nombre', '$email')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "nombre" => $nombre, "email" => $email]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Error al guardar"]);
}

$conn->close();
