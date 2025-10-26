<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servidor = "localhost";
    $usuario_db = "root";
    $contrasena_db = "";
    $nombre_db = "banorte";

    $usuario_recibido = trim($_POST['usuario'] ?? '');
    $contrasena_recibida = trim($_POST['contrasena'] ?? '');

    if (empty($usuario_recibido) || empty($contrasena_recibida)) {
        echo "<script>alert('Por favor, ingresa usuario y contraseña.'); window.history.back();</script>";
        exit;
    }

    $conn = new mysqli($servidor, $usuario_db, $contrasena_db, $nombre_db);
    if ($conn->connect_error) {
        echo "<script>alert('Error de conexión con la base de datos.'); window.history.back();</script>";
        exit;
    }

// ✅ Selecciona TAMBIÉN el ID
$sql = "SELECT id, password FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "<script>alert('Error interno al preparar la consulta.'); window.history.back();</script>";
    exit;
}

$stmt->bind_param("s", $usuario_recibido);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();
    $pass_guardada = $fila['password'];

    if ($contrasena_recibida === $pass_guardada) {
        // ✅ Ahora sí existe $fila['id']
        $_SESSION['usuario_logueado'] = $usuario_recibido;
        $_SESSION['usuario_id'] = $fila['id'];

        echo "<script>window.location.href='../paginaprincipal.php';</script>";
        exit;
    } else {
        echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
        exit;
    }
    } else {
        echo "<script>alert('Usuario no encontrado o datos incorrectos.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Acceso denegado. Por favor, inicia sesion desde el formulario.'); window.location.href='../paginaprincipal.php';</script>";
    exit;
}
?>
