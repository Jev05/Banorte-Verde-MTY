<?php
session_start();
if(!isset($_SESSION['usuario_logueado'])){
    header("Location: ../paginaprincipal.php");
    exit;
}

include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
    $cuenta_origen = $_POST['cuenta_origen'];
    $clabe_destino = $_POST['clabe_destino'];
    $importe = floatval($_POST['importe']);
    $referencia = $_POST['referencia'];
    $concepto = $_POST['concepto'];
    $fecha_operacion = $_POST['fecha_operacion'];

    // Tipo de movimiento: 0 = egreso
    $tipo_movimiento = 0;

    // ID del emisor (usuario logueado)
    $emisor = $_SESSION['usuario_id'] ?? 0;

    // Verificar que el emisor existe
    if ($emisor === 0) {
        die("Error: No se pudo obtener el ID del usuario logueado. Por favor, inicia sesión nuevamente.");
    }

    // Verificar que el emisor tenga saldo suficiente
    $stmt_saldo = $conn->prepare("SELECT saldo FROM usuarios WHERE id = ?");
    $stmt_saldo->bind_param("i", $emisor);
    $stmt_saldo->execute();
    $result_saldo = $stmt_saldo->get_result();
    
    if ($result_saldo->num_rows === 1) {
        $row_saldo = $result_saldo->fetch_assoc();
        $saldo_actual = floatval($row_saldo['saldo']);
        
        if ($saldo_actual < $importe) {
            echo "<script>alert('Saldo insuficiente. Saldo actual: $" . number_format($saldo_actual, 2) . "'); window.history.back();</script>";
            $stmt_saldo->close();
            $conn->close();
            exit;
        }
    }
    $stmt_saldo->close();

    $stmt_buscar_ref = $conn->prepare("SELECT id FROM referencia WHERE referenciaVal = ?");
    $stmt_buscar_ref->bind_param("s", $referencia);
    $stmt_buscar_ref->execute();
    $result_ref = $stmt_buscar_ref->get_result();

    if ($result_ref->num_rows === 1) {
        // La referencia ya existe, obtener su ID
        $row_ref = $result_ref->fetch_assoc();
        $referencia_id = $row_ref['id'];
        $stmt_buscar_ref->close();

    } else {
        // La referencia no existe, crearla
        $stmt_buscar_ref->close();
    }
    // Buscar ID del destinatario a partir de la CLABE
    $stmt_destinatario = $conn->prepare("SELECT id FROM usuarios WHERE nocuenta = ?");
    $stmt_destinatario->bind_param("s", $clabe_destino);
    $stmt_destinatario->execute();
    $result_destinatario = $stmt_destinatario->get_result();

    if ($result_destinatario->num_rows === 1) {
        $row = $result_destinatario->fetch_assoc();
        $remitente = $row['id'];
        $stmt_destinatario->close();

        // Insertar la transacción
        $stmt = $conn->prepare("INSERT INTO transacciones (emisor, remitente, tipo_movimiento, fecha, motivo, monto, referencia) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissds", $emisor, $remitente, $tipo_movimiento, $fecha_operacion, $concepto, $importe, $referencia_id);

        if($stmt->execute()){
            
            echo "<script>alert('Transacción registrada correctamente\\nSaldo transferido: $" . number_format($importe, 2) . "'); window.location.href='../pago.php';</script>";
        } else {
            echo "<script>alert('Error al registrar la transacción: " . $conn->error . "'); window.history.back();</script>";
        }
        $stmt->close();

    } else {
        echo "<script>alert('No se encontró un usuario con esa CLABE'); window.history.back();</script>";
        $stmt_destinatario->close();
    }
}
$conn->close();
?>