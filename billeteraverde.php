<?php
session_start();
$logeado = isset($_SESSION['usuario_logueado']);
if($logeado){ 
include "php/conexion.php";



$nombre_usuario = "Usuario no encontrado";
$imagen_qr_base64 = "";
$error_mensaje = "";

    $usuario_id = $_SESSION['usuario_logueado'];
  //$usuario_id = 156;


    // MEJORA: Prepared statement para seguridad
    $stmt = $conn->prepare("SELECT id, email, puntos FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_usuario = $usuario_id;
        $id_us = $row["id"];
        $email_usuario = $row["email"];
        $puntos = $row['puntos'];
        
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
        $error_mensaje = "No se encontró un usuario con el ID: " . htmlspecialchars($id_us);
    }
    
    $stmt->close();


$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Banorte - Billetera Digital Banorte Verde</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="styles/styles.css">
</head>

<body class="min-h-screen">

  <header class="bg-main p-3 shadow-md">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <div class="logo"><a href="paginaprincipal.html"><img src="LogoBanorte.png" alt="Logo Banorte"
            style="width: 300px; height: 200px; object-fit: contain;"></a></div>
      <div class="hidden md:flex space-x-6 text-sm font-semibold text-white">
        <span>Bienvenido(a) <span id="u-name" class="font-bold">USUARIO ADMINISTRADOR - 1555983</span> (Empresa: <span
            class="font-bold">Todas</span>)</span>
      </div>
    </div>
  </header>

  <nav class="bg-[#5B6670] shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-12 space-x-10">
                <a href="paginaprincipal.php"
                    class="text-white flex items-center p-2 border-b-2 border-transparent hover:border-[#EB0029] transition-all duration-300">Pagina Principal</a>
                <a href="pago.php"
                    class="text-white flex items-center p-2 border-b-2 border-[#EB0029]">Pagos/Transferencias</a>
                <a href="servicios.php"
                    class="text-white flex items-center p-2 border-b-2 border-transparent hover:border-[#EB0029] transition-all duration-300">Pagar
                    servicios</a>
                <a href="billeteraverde.php"
                    class="text-white flex items-center p-2 border-b-2 border-transparent hover:border-[#EB0029] transition-all duration-300">Billetera
                    digital Banorte verde</a>
                <a href="php/logout.php"
                    class="text-white flex items-center p-2 border-b-2 border-transparent hover:border-[#EB0029] transition-all duration-300">Cerrar Sesion</a>
            </div>
    </div>
  </nav>



  <main class="max-w-7xl mx-auto p-6">
    <h1 class="text-lg font-bold text-main mb-4">Billetera Digital — Banorte Verde</h1>

    <div class="grid-main">
      <section class="card p-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <div class="text-sm muted">Titular</div>
            <div id="holder-name" class="value-small mt-1">USUARIO ADMINISTRADOR – 1555983</div>
          </div>
          <div class="text-right">
            <div class="text-sm muted">Ecopuntos disponibles</div>
            <div id="ecopoints" class="value-lg mt-1">100</div>
            <div class="muted text-xs mt-1">Equivalente aproximado: <span id="ecopoints-mxn">0.00 M.N.</span></div>
          </div>
        </div>

        <hr class="my-4" />

        <div class="mb-4">
          <div class="text-sm muted mb-2">Información</div>
          <p class="muted text-sm">
            Los Ecopuntos se acreditan en su cuenta automáticamente tras la validación del proceso de reciclaje en las
            máquinas autorizadas. Para completar el ciclo de acreditación, presente el código QR desde este panel en la
            máquina o utilice el mecanismo que su proveedor haya acordado con Banorte.
          </p>
        </div>

        <div class="flex gap-3 mt-6">
          <button id="btn-generate" class="btn-primary">Generar QR</button>
          <button id="btn-refresh"
            class="border border-gray-300 px-4 rounded-md h-11 text-sm text-gray-700 hover:border-red-500 hover:text-red-500 transition-colors duration-200">
            Actualizar saldo
          </button>
        </div>

        <div class="mt-6 text-xs muted">
          <strong>Notas:</strong> El código QR tiene vigencia corta. El proceso de acreditación y la contabilidad final
          se realizan en el sistema back-end de Banorte.
        </div>
      </section>
      <section class="card p-6">
        <div class="flex items-start justify-between mb-4">
          <div>
            <div class="text-sm muted">Código QR de reciclaje</div>
            <div class="muted text-xs">Este código identifica la operación de acreditación de Ecopuntos para la máquina
              / punto de recolección.</div>
          </div>
          <div class="muted text-xs">Estado: <span id="qr-status">Esperando generación</span></div>
        </div>

        <div class="mt-4 flex flex-col lg:flex-row lg:items-start lg:gap-6">
          <div class="qr-box flex items-center justify-center">
            <?php
              if (!empty($imagen_qr_base64)) {
                  // mostramos el QR generado desde PHP con el mismo estilo del canvas
                  echo '<img src="' . $imagen_qr_base64 . '" 
                            alt="Código QR" 
                            width="216" 
                            height="216"
                            style="background:#fff; border-radius:4px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">';
              } else {
                  // si hay error, se muestra el mensaje en rojo dentro del mismo contenedor
                  echo '<div style="width:216px; height:216px; background:#fff; border-radius:4px; 
                                  display:flex; align-items:center; justify-content:center; 
                                  box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                            <p style="color:#e60000; font-weight:600; text-align:center; padding:10px;">' . $error_mensaje . '</p>
                        </div>';
              }
            ?>
          </div>

          <div class="mt-4 lg:mt-0 flex-1">
            <div class="mb-3">
              <label class="text-sm muted">Token / Referencia (para backend)</label>
              <div id="qr-token" class="mt-2 font-mono text-sm break-all">—</div>
            </div>

            <div class="mb-3">
              <label class="text-sm muted">Vigencia</label>
              <div id="qr-expiry" class="mt-2 text-sm">—</div>
            </div>

            <div class="mt-4">
              <button id="btn-regenerate" class="btn-primary mr-3">Regenerar QR</button>
              <button id="btn-download"
                class="border border-gray-300 px-4 rounded-md h-11 text-sm text-gray-700 hover:border-red-500 hover:text-red-500 transition-colors duration-200">
                Descargar QR
              </button>

            </div>
          </div>
        </div>

        <hr class="my-6" />

        <div>
          <div class="text-sm muted">Última acreditación (referencia mínima)</div>
          <div class="mt-2 text-sm muted">Última actualización: <span id="last-accreditation">—</span></div>
        </div>
      </section>
    </div>
    <div id="integration" data-user-id="__USER_ID__" data-wallet-id="__WALLET_ID__" style="display:none;"></div>
  </main>

  <script>
    function nowIsoPlusMinutes(mins) {
      const d = new Date();
      d.setMinutes(d.getMinutes() + mins);
      return d.toISOString();
    }
    async function generateToken(userId) {
      const rand = crypto.getRandomValues(new Uint8Array(16));
      const randHex = Array.from(rand).map(b => b.toString(16).padStart(2, '0')).join('');
      const ts = Date.now().toString(36);
      return `bv_${userId || 'anon'}_${ts}_${randHex}`;
    }

    async function drawQrLike(canvas, token) {
      const ctx = canvas.getContext('2d');
      const size = Math.min(canvas.width, canvas.height);
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      // fondo blanco
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      const enc = new TextEncoder().encode(token);
      const hashBuffer = await crypto.subtle.digest('SHA-256', enc);
      const hash = new Uint8Array(hashBuffer);

      const grid = 21;
      const cell = Math.floor((size - 8) / grid); // 4px padding approx
      const padding = Math.floor((size - cell * grid) / 2);

      let bi = 0;
      for (let y = 0; y < grid; y++) {
        for (let x = 0; x < grid; x++) {
          const byte = hash[bi % hash.length];
          const bit = (byte >> (bi % 8)) & 0x1;
          ctx.fillStyle = bit ? '#111827' : '#ffffff';
          ctx.fillRect(padding + x * cell, padding + y * cell, cell, cell);
          bi++;
        }
      }

      ctx.strokeStyle = '#E5E7EB';
      ctx.lineWidth = 1;
      ctx.strokeRect(padding - 2, padding - 2, cell * grid + 4, cell * grid + 4);
    }

    function downloadCanvas(canvas, filename = 'qr-billetera-verde.png') {
      const link = document.createElement('a');
      link.href = canvas.toDataURL('image/png');
      link.download = filename;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }

    const ui = {
      ecopointsEl: document.getElementById('ecopoints'),
      ecopointsMxnEl: document.getElementById('ecopoints-mxn'),
      holderNameEl: document.getElementById('holder-name'),
      qrCanvas: document.getElementById('qr-canvas'),
      qrTokenEl: document.getElementById('qr-token'),
      qrExpiryEl: document.getElementById('qr-expiry'),
      qrStatusEl: document.getElementById('qr-status'),
      lastAccEl: document.getElementById('last-accreditation'),
      integrationEl: document.getElementById('integration')
    };

    const backendPlaceholders = {
      userId: (ui.integrationEl.dataset.userId && ui.integrationEl.dataset.userId !== '__USER_ID__') ? ui.integrationEl.dataset.userId : '1555983',
      walletId: (ui.integrationEl.dataset.walletId && ui.integrationEl.dataset.walletId !== '__WALLET_ID__') ? ui.integrationEl.dataset.walletId : 'WALLET_0001',
      ecopoints: <?php echo isset($puntos) ? floatval($puntos) : 0; ?>,
      ecopointsMxn: '<?php echo isset($puntos) ? floatval($puntos) : 0; ?> M.N.',
      holderName: ui.holderNameEl.textContent.trim()
    };

    function populatePlaceholders() {
      ui.ecopointsEl.textContent = backendPlaceholders.ecopoints;
      ui.ecopointsMxnEl.textContent = backendPlaceholders.ecopointsMxn;
      ui.holderNameEl.textContent = backendPlaceholders.holderName;
    }

    async function generateAndRenderQr({ auto = false } = {}) {
      try {
        ui.qrStatusEl.textContent = 'Generando...';
        const token = await generateToken(backendPlaceholders.userId);
        const expiryIso = nowIsoPlusMinutes(10);
        await drawQrLike(ui.qrCanvas, token);

        ui.qrTokenEl.textContent = token;
        ui.qrExpiryEl.textContent = (new Date(expiryIso)).toLocaleString();
        ui.qrStatusEl.textContent = 'Válido';
      } catch (err) {
        ui.qrStatusEl.textContent = 'Error generando';
        console.error(err);
      }
      const backendPlaceholders = {
        userId: (ui.integrationEl.dataset.userId && ui.integrationEl.dataset.userId !== '__USER_ID__') ? ui.integrationEl.dataset.userId : '1555983',
        walletId: (ui.integrationEl.dataset.walletId && ui.integrationEl.dataset.walletId !== '__WALLET_ID__') ? ui.integrationEl.dataset.walletId : 'WALLET_0001',
        ecopoints: 0,
        ecopointsMxn: '0.00 M.N.',
        holderName: ui.holderNameEl.textContent.trim()
      };

      function populatePlaceholders() {
        ui.ecopointsEl.textContent = backendPlaceholders.ecopoints;
        ui.ecopointsMxnEl.textContent = backendPlaceholders.ecopointsMxn;
        ui.holderNameEl.textContent = backendPlaceholders.holderName;
      }

      async function generateAndRenderQr({ auto = false } = {}) {
        try {
          ui.qrStatusEl.textContent = 'Generando...';
          const token = await generateToken(backendPlaceholders.userId);
          const expiryIso = nowIsoPlusMinutes(10);
          await drawQrLike(ui.qrCanvas, token);

          ui.qrTokenEl.textContent = token;
          ui.qrExpiryEl.textContent = (new Date(expiryIso)).toLocaleString();
          ui.qrStatusEl.textContent = 'Válido';
        } catch (err) {
          ui.qrStatusEl.textContent = 'Error generando';
          console.error(err);
        }
      }

      async function refreshSaldoFromBackend() {
        backendPlaceholders.ecopoints = backendPlaceholders.ecopoints + 0;
        backendPlaceholders.ecopointsMxn = backendPlaceholders.ecopointsMxn;
        populatePlaceholders();
      }

    }

    async function refreshSaldoFromBackend() {

      backendPlaceholders.ecopoints = backendPlaceholders.ecopoints + 0; // sin cambio
      backendPlaceholders.ecopointsMxn = backendPlaceholders.ecopointsMxn;
      populatePlaceholders();
    }

    document.getElementById('btn-generate').addEventListener('click', () => generateAndRenderQr({ auto: false }));
    document.getElementById('btn-regenerate').addEventListener('click', () => generateAndRenderQr({ auto: false }));
    document.getElementById('btn-download').addEventListener('click', () => downloadCanvas(ui.qrCanvas));

    document.getElementById('btn-refresh').addEventListener('click', () => refreshSaldoFromBackend());

    (async function init() {
      populatePlaceholders();
      await refreshSaldoFromBackend();
      await generateAndRenderQr({ auto: true });
    })();
  </script>
</body>

</html>

<?php }else{
    header("Location: paginaprincipal.php"); 
    exit;}?>