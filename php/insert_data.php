<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include 'config.php';
$input=json_decode(file_get_contents('php://input'), true);
if(isset($input['nombre'])&& isset($input['Email'])){
    $nombre = $conn->real_escape_string($input['nombre']);
    $email = $conn->real_escape_string($input['email']);
    
    $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Datos insertados correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

$conn->close();
?>