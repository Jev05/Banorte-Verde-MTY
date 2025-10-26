<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['usuario_logueado'])) {
    header("Location: ../paginaprincipal.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id']; // Este es el ID numérico del usuario
$servicio = $_POST['servicio'] ?? '';
$referencia = $_POST['referencia'] ?? '';
$importe = floatval($_POST['importe'] ?? 0);
$puntosUsar = floatval($_POST['puntosUsar'] ?? 0); // Permite decimales

// 🧩 Validar datos
if (empty($servicio) || empty($referencia) || $importe <= 0) {
    echo "<script>alert('Datos incompletos. Verifique la información.'); window.history.back();</script>";
    exit;
}

// 🔹 Asignar remitente según servicio
switch (strtolower($servicio)) {
    case 'cfe':      $remitente = 219; break;
    case 'agua':     $remitente = 182; break;
    case 'telmex':
    case 'teléfono':
    case 'telefono': $remitente = 228; break;
    case 'internet': $remitente = 229; break;
    case 'predial':  $remitente = 234; break;
    default:         $remitente = 0; break;
}

// 🔹 Traer puntos actuales del usuario
$result = mysqli_query($conn, "SELECT puntos FROM usuarios WHERE id = '$usuario_id'");
$row = mysqli_fetch_assoc($result);
$disponibles = floatval($row['puntos'] ?? 0);

// 🔹 Validar y ajustar puntos a usar
if ($puntosUsar > $disponibles) {
    $puntosUsar = $disponibles;
}
if ($puntosUsar > $importe) {
    // No puede usar más puntos que el importe a pagar
    $puntosUsar = $importe;
}

// 🔹 Calcular total a pagar
$totalPagar = $importe - $puntosUsar;

// 🔹 Actualizar los puntos del usuario
$nuevosPuntos = $disponibles - $puntosUsar;
mysqli_query($conn, "UPDATE usuarios SET puntos = $nuevosPuntos WHERE id = '$usuario_id'");

// 🔹 Buscar o insertar la referencia
$queryRef = "SELECT id FROM referencia WHERE referenciaVal = '$referencia' LIMIT 1";
$resRef = mysqli_query($conn, $queryRef);

if (mysqli_num_rows($resRef) > 0) {
    $refData = mysqli_fetch_assoc($resRef);
    $idReferencia = $refData['id'];
} else {
    mysqli_query($conn, "INSERT INTO referencia (referenciaVal) VALUES ('$referencia')");
    $idReferencia = mysqli_insert_id($conn);
}

// 🔹 Registrar transacción
$tipo_movimiento = 0; // egreso
$motivo = ucfirst($servicio);
$queryInsert = "INSERT INTO transacciones (id, emisor, remitente, tipo_movimiento, fecha, motivo, monto, referencia)
VALUES (NULL, '$usuario_id', '$remitente', '$tipo_movimiento', NOW(), '$motivo', '$totalPagar', '$idReferencia')";

if (mysqli_query($conn, $queryInsert)) {
    echo "<script>
        alert('Pago realizado con éxito. Total pagado: $$totalPagar MXN (Puntos usados: $puntosUsar)');
        window.location.href='../paginaprincipal.php';
    </script>";
} else {
    echo "<script>
        alert('Error al registrar la transacción: " . mysqli_error($conn) . "');
        window.history.back();
    </script>";
}
?>
