<<<<<<< HEAD
<?php
header("Content-Type: application/json");
include("conexion.php"); // tu archivo con mysqli_connect()

$data = json_decode(file_get_contents("php://input"), true);

$correo = $data["correo"] ?? "";
$cantidad = intval($data["puntos"] ?? 0);

if (!$correo || $cantidad <= 0) {
    echo json_encode(["success" => false, "message" => "Datos inválidos."]);
    exit;
}

// Verificar si el usuario existe
$query = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si existe, aumentar la cantidad de botellas
    $update = "UPDATE usuarios SET puntos = puntos + ? WHERE correo = ?";
    $stmt2 = $conn->prepare($update);
    $stmt2->bind_param("is", $cantidad, $correo);
    $stmt2->execute();
    echo json_encode(["success" => true, "message" => "Cantidad actualizada."]);
} else {
    // Si no existe, crear el registro
    $insert = "INSERT INTO usuarios (correo, puntos) VALUES (?, ?)";
    $stmt3 = $conn->prepare($insert);
    $stmt3->bind_param("si", $correo, $cantidad);
    $stmt3->execute();
    echo json_encode(["success" => true, "message" => "Usuario agregado con éxito."]);
}
?>
=======
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "banorte";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// CORREGIDO: Era $data["cantidad"] en lugar de $data["correo"]
$correo = $data["correo"] ?? "";
$cantidad = intval($data["cantidad"] ?? 0);

if (!$correo || $cantidad <= 0) {
    echo json_encode(["success" => false, "message" => "Datos inválidos. Correo: $correo, Cantidad: $cantidad"]);
    exit;
}

$query = "SELECT * FROM usuarios WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $update = "UPDATE usuarios SET puntos = puntos + ? WHERE Email = ?";
    $stmt2 = $conn->prepare($update);
    $stmt2->bind_param("is", $cantidad, $correo);
    
    if ($stmt2->execute()) {
        echo json_encode(["success" => true, "message" => "Cantidad actualizada correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar: " . $stmt2->error]);
    }
} else {
    $insert = "INSERT INTO usuarios (Email, puntos) VALUES (?, ?)";
    $stmt3 = $conn->prepare($insert);
    $stmt3->bind_param("si", $correo, $cantidad);
    
    if ($stmt3->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario agregado con éxito."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al insertar: " . $stmt3->error]);
    }
}

$conn->close();
?>
>>>>>>> 2b042ec (Lector QR con envio de informacion)
