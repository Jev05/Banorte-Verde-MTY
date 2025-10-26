<?php
session_start();
$logeado = isset($_SESSION['usuario_logueado']);
if ($logeado) {

  include("php/conexion.php"); // Asegúrate de tener la conexión
  $usuario = $_SESSION['usuario_logueado'];
  // Consulta de puntos del usuario
  $query = "SELECT puntos FROM usuarios WHERE usuario = '$usuario'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $puntos = $row['puntos'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Banorte - Pago de Servicios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body class="min-h-screen">

  <!-- ENCABEZADO -->
  <header class="bg-main p-3 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <div class="logo">
        <a href="paginaprincipal.html">
          <img src="LogoBanorte.png" alt="Logo Banorte" style="width: 300px; height: 200px; object-fit: contain;">
        </a>
      </div>
      <div class="hidden md:flex space-x-6 text-sm font-semibold text-white">
        <span>Bienvenido(a) <span class="font-bold"><?= strtoupper($usuario) ?></span></span>
      </div>
    </div>
  </header>

  <!-- NAV -->
  <nav class="bg-[#5B6670] shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-center h-12 space-x-10">
        <a href="paginaprincipal.php" class="text-white p-2 hover:border-[#EB0029] border-b-2 border-transparent">Pagina Principal</a>
        <a href="pago.php" class="text-white p-2 border-b-2 border-[#EB0029]">Pagos/Transferencias</a>
        <a href="servicios.php" class="text-white p-2 hover:border-[#EB0029] border-b-2 border-transparent">Pagar servicios</a>
        <a href="billeteraverde.php" class="text-white p-2 hover:border-[#EB0029] border-b-2 border-transparent">Billetera verde</a>
        <a href="php/logout.php" class="text-white p-2 hover:border-[#EB0029] border-b-2 border-transparent">Cerrar Sesión</a>
      </div>
    </div>
  </nav>

  <!-- CONTENIDO -->
  <main class="max-w-7xl mx-auto p-6">
    <h1 class="text-lg font-bold text-main mb-4">Pago de sus servicios</h1>

    <!-- SECCIÓN DE SERVICIOS -->
    <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
      <div class="service-card" data-service="CFE"><div class="service-icon">💡</div><p>Luz (CFE)</p></div>
      <div class="service-card" data-service="Agua"><div class="service-icon">🚰</div><p>Agua</p></div>
      <div class="service-card" data-service="Telmex"><div class="service-icon">📞</div><p>Teléfono (Telmex)</p></div>
      <div class="service-card" data-service="Internet"><div class="service-icon">🌐</div><p>Internet</p></div>
      <div class="service-card" data-service="Predial"><div class="service-icon">🏠</div><p>Predial</p></div>
    </section>

    <!-- FORMULARIO DETALLE -->
    <div id="detalle-servicio" class="hidden border border-gray-300 p-6 bg-white shadow-md rounded-lg">
      <div class="flex justify-between items-center mb-4 border-b border-main pb-2">
        <h2 id="titulo-servicio" class="text-base font-bold text-gray-700">Detalle del Pago</h2>
        <span class="text-xs text-gray-500">PASO 1 DE 1</span>
      </div>

      <form id="formPago" action="php/procesar_pago.php" method="POST" class="space-y-3">
        <input type="hidden" name="servicio" id="servicio">

        <div class="grid grid-cols-12 items-center gap-4 relative">
          <label for="referencia" class="col-span-3 text-right text-sm">Referencia:</label>
          <div class="col-span-6 relative">
            <input type="text" id="referencia" name="referencia" class="form-input-select" placeholder="Ingrese su número de servicio" required>
          </div>
        </div>

        <div class="grid grid-cols-12 items-center gap-4 relative">
          <label for="importe" class="col-span-3 text-right text-sm">Importe:</label>
          <div class="col-span-2 relative">
            <input type="number" id="importe" name="importe" class="form-input-select text-right" step="0.01" placeholder="0.00" required>
          </div>
          <span class="text-gray-600 text-sm col-span-1">MXN</span>
        </div>

        <!-- NUEVA SECCIÓN: puntos -->
        <div class="border-t border-gray-300 my-4 pt-4">
          <h3 class="font-semibold text-gray-700">Usar puntos</h3>
          <p class="text-sm text-gray-600 mb-2">Tienes disponibles: <span id="puntosDisponibles" class="font-bold text-green-600"><?= $puntos ?></span> puntos</p>
          
          <div class="flex items-center space-x-2 mb-2">
            <input type="checkbox" id="usarPuntos" class="cursor-pointer">
            <label for="usarPuntos" class="text-sm text-gray-700">Usar puntos para pagar</label>
          </div>

          <div id="campoPuntos" class="hidden flex items-center space-x-2">
            <label for="puntosUsar" class="text-sm">Cantidad a usar:</label>
            <input type="number" id="puntosUsar" name="puntosUsar" class="border p-1 rounded w-24 text-right" min="0" max="<?= $puntos ?>" step="0.01">
            <span class="text-xs text-gray-500">(1 punto = $1 MXN)</span>
          </div>

          <p class="text-sm mt-2 text-gray-600">Total a pagar: <span id="totalFinal" class="font-bold">$0.00</span></p>
        </div>

        <div class="mt-8 border-t border-gray-300 pt-4 flex justify-between items-center">
          <span class="text-xs text-gray-500">Verifique los datos antes de continuar</span>
          <button type="submit" class="btn">Pagar</button>
        </div>
      </form>
    </div>
  </main>

  <script>
    const serviceCards = document.querySelectorAll('.service-card');
    const detalle = document.getElementById('detalle-servicio');
    const titulo = document.getElementById('titulo-servicio');
    const servicioInput = document.getElementById('servicio');
    const importeInput = document.getElementById('importe');
    const usarPuntos = document.getElementById('usarPuntos');
    const campoPuntos = document.getElementById('campoPuntos');
    const puntosUsar = document.getElementById('puntosUsar');
    const puntosDisponibles = parseFloat(document.getElementById('puntosDisponibles').textContent);
    const totalFinal = document.getElementById('totalFinal');

    // Mostrar detalle del servicio
    serviceCards.forEach(card => {
      card.addEventListener('click', () => {
        serviceCards.forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        detalle.classList.remove('hidden');
        titulo.textContent = `Pago de servicio: ${card.dataset.service}`;
        servicioInput.value = card.dataset.service;
        detalle.scrollIntoView({ behavior: 'smooth' });
      });
    });

    // Mostrar/ocultar campo de puntos
    usarPuntos.addEventListener('change', () => {
      campoPuntos.classList.toggle('hidden', !usarPuntos.checked);
      calcularTotal();
    });

    // Recalcular total
    [importeInput, puntosUsar].forEach(el => el.addEventListener('input', calcularTotal));

    function calcularTotal() {
      const importe = parseFloat(importeInput.value) || 0;
      const usar = usarPuntos.checked ? Math.min(parseFloat(puntosUsar.value) || 0, puntosDisponibles) : 0;
      const total = Math.max(importe - usar, 0);
      totalFinal.textContent = `$${total.toFixed(2)}`;
    }
  </script>
</body>
</html>

<?php
} else {
  header("Location: paginaprincipal.php");
  exit;
}
?>
