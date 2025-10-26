<?php

include "conexion.php";

    $sql = "SELECT id, nombre FROM usuarios";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        
    
    $id = $row["id"];
    $nombre=$row['nombre'];
        }
    echo "</table>";
    } else {
    echo "No hay resultados.";
    }

    $conn->close();

$texto = "$id&$nombre";
$url = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($texto);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>QR funcional</title>
</head>
<body>
  <h2>Código QR</h2>
    
  <img src="<?php echo $url; ?>" alt="Código QR generado">
</body>
</html>
