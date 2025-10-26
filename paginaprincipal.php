<?php
session_start();
$logeado = isset($_SESSION['usuario_logueado']);

$saldo_usuario = null;

if($logeado){
    include "php/conexion.php";

    // Obtener saldo del usuario logueado
    $stmt = $conn->prepare("SELECT saldo FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $_SESSION['usuario_logueado']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $row = $result->fetch_assoc();
        $saldo_usuario = $row['saldo'];
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banorte - Banca en Línea</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/styles.css">
    <style>
        body {
            font-family: "Gotham";
            background-color: white;
            background: #ffffff;
            min-height: 100vh;
        }

        /* Mantiene la animación del label flotante */
        .float-label {
            top: 0.25rem !important;
            font-size: 0.75rem !important;
            color: #e60000 !important;
        }
    </style>
</head>

<body class="min-h-screen">

    <header class="bg-main p-3 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="logo" style="display: flex; justify-content: flex-start; align-items: center;">
                    <a href="paginaprincipal.html">
                        <img src="LogoBanorte.png" alt="Logo Banorte"
                            style="width: 300px; height: 200px; object-fit: contain;">
                    </a>
                </span>
            </div>
        </div>
    </header>

    <nav class="bg-[#5B6670] shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center h-12 space-x-10">
                <?php if($logeado): ?>
                <a href="pago.php" id="linkpartesuperior">Pago/Transferencia</a>
                <a href="servicios.php" id="linkpartesuperior">Pagar servicios</a>
                <a href="billeteraverde.php" id="linkpartesuperior">Billetera digital Banorte Verde</a>
                <a href="php/logout.php" id="linkpartesuperior">Cerrar Sesion</a>
                <?php else: ?>
                <!-- Aquí no mostramos menú si no está logueado -->
            <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-4 lg:p-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-1">
            <div class="box p-6 bg-white">

                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Banco en Línea</h2>

                <div class="space-y-4">
                    <?php if(!$logeado): ?>
                    <form action="php/login.php" method="POST" class="space-y-4">
                    <!-- Campo de usuario -->
                    <div class="relative input-wrapper">
                        <input type="text" id="usuario" name="usuario" placeholder=" " oninput="toggleLabel('usuario')"
                            class="border border-gray-300 rounded-md px-3 py-3 w-full text-sm text-gray-700 focus:border-red-500 outline-none transition-all duration-200">
                        <label for="usuario" id="usuario-label"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-sm font-semibold text-gray-700 pointer-events-none transition-all duration-200">Usuario</label>
                        <button id="clear-btn" onclick="clearInput('usuario')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors duration-200">×</button>
                    </div>

                    <!-- Campo de contraseña -->
                    <div class="relative input-wrapper">
                        <input type="password" id="contrasena" name="contrasena" placeholder=" " oninput="toggleLabel('contrasena')"
                            class="border border-gray-300 rounded-md px-3 py-3 w-full text-sm text-gray-700 focus:border-red-500 outline-none transition-all duration-200">
                        <label for="contrasena" id="contrasena-label"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-sm font-semibold text-gray-700 pointer-events-none transition-all duration-200">Contraseña</label>
                        <button id="clear-btn-pass" onclick="clearInput('contrasena')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors duration-200">×</button>
                    </div>

                    <!-- Botón entrar -->
                    <button type="submit"
                        class="btn border border-gray-300 px-4 rounded-md h-11 text-sm text-gray-700 hover:border-red-500 hover:text-red-500 transition-colors duration-200 w-full"
                        id="primario">ENTRAR</button>
                </form>
                <?php else: ?>
                    <p class="text-red-600 font-bold">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_logueado']); ?>!</p>
                <?php endif; ?>
                </div>

                <div class="mt-5 text-sm space-y-2">
                    <div class="flex items-center justify-between">
                        <a href="#" class="">Activa tu token</a>
                        <?php if($logeado && $saldo_usuario !== null): ?>
            <span class="text-xl font-bold mb-6 text-gray-800 border-b pb-3">Saldo: $<?php echo number_format($saldo_usuario, 2); ?> MXN</span>
        <?php else: ?>
            <a href="#" class="text-black-600 hover:underline font-medium">Ayuda</a>
        <?php endif; ?>
                    </div>
                    <a href="#" class="text-black-600 hover:underline font-medium">Sincroniza tu token</a>
                </div>

                <div class="mt-8 border-t pt-4">
                    <details>
                        <summary class="cursor-pointer text-black-600 hover:text-red-600 font-bold text-sm">Otras
                            Cuentas</summary>
                        <ul class="ml-4 mt-2 text-sm text-gray-600 list-disc pl-5 space-y-1">
                            <li><a href="#" class="hover:text-main">Empresariales</a></li>
                            <li><a href="#" class="hover:text-main">Preferente</a></li>
                        </ul>
                    </details>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div
                class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-8 h-full min-h-[300px]">
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-800 leading-tight">
                        ¿SABES POR QUÉ <span class="text-main">PAGARÉ BANORTE</span> MULTIPLICA TU DINERO?
                    </h1>
                    <p class="mt-4 text-gray-600 font-medium text-lg">
                        PORQUE ENCUENTRAS CÓMO AUMENTAR TU RENDIMIENTO.
                    </p>
                </div>

                <div class="w-full md:w-1/2 flex justify-center py-6 md:py-0">
                    <div class="circle">
                        <span class="circle-text">PAGARÉ</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-6 space-x-2">
                <span class="dot bg-main h-2 w-2"></span>
                <span class="dot bg-gray-300 h-2 w-2"></span>
                <span class="dot bg-gray-300 h-2 w-2"></span>
            </div>
        </div>
    </main>

    <section class="max-w-7xl mx-auto p-8 mt-12 text-center">
        <h2 class="text-3xl font-bold text-main">Diseñamos soluciones de vida</h2>
        <p class="mt-2 text-gray-600 text-lg">Acompañándote en cada paso para que sigas avanzando.</p>
    </section>

    <script>
        function clearInput(id) {
            const input = document.getElementById(id);
            input.value = "";
            toggleLabel(id);
            input.focus();
        }

        function toggleLabel(id) {
            const input = document.getElementById(id);
            const label = document.getElementById(id + '-label');
            if (input.value.trim() !== '') {
                label.classList.add('float-label');
            } else {
                label.classList.remove('float-label');
            }
        }
    </script>

</body>

</html>
