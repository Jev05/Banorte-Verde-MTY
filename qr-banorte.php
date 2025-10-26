<?php
include "banortee.php";

$nombre_usuario = "Usuario no encontrado";
$imagen_qr_base64 = "";
$error_mensaje = "";

//if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  //  $usuario_id = (int)$_GET['id'];
  $usuario_id = 152;
    
    // MEJORA: Prepared statement para seguridad
    $stmt = $conn->prepare("SELECT nombre, email FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_usuario = $row["nombre"];
        $email_usuario = $row["email"];
        
        if (!empty($email_usuario)) {
            // VALIDACIÓN: Verificar que el email sea válido
            if (filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
                
                // ✅ EMAIL ENCODEADO EN BASE64
                $email_encoded = base64_encode($email_usuario);
                
                // Generar QR con el email encodeado
                $url_api = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($email_encoded);
                
                // MEJORA: Manejo de errores de la API
                $datos_imagen = @file_get_contents($url_api);
                if ($datos_imagen !== FALSE) {
                    $imagen_qr_base64 = 'data:image/png;base64,' . base64_encode($datos_imagen);
                } else {
                    $error_mensaje = "Error al generar el código QR desde la API.";
                }
                
            } else {
                $error_mensaje = "El email registrado no es válido.";
            }
        } else {
            $error_mensaje = "Este usuario no tiene un email registrado.";
        }

    } else {
        $error_mensaje = "No se encontró un usuario con el ID: " . htmlspecialchars($usuario_id);
    }
    
    $stmt->close();

/*} else {
    $error_mensaje = "Por favor, proporciona un ID de usuario válido en la URL ";
}*/
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Generador de QR Codificado</title>
  <style>
    body { 
        font-family: Arial, sans-serif; 
        margin: 20px;
        text-align: center;
    }
    h2 {
        margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <h2>Código QR para: <?php echo htmlspecialchars($nombre_usuario); ?></h2>
  
  <?php
    if (!empty($imagen_qr_base64)) {
        echo '<img src="' . $imagen_qr_base64 . '" alt="Código QR con email encodeado">';
    } else {
        echo '<p style="color: red;">' . $error_mensaje . '</p>';
    }
  ?>
</body>
</html>