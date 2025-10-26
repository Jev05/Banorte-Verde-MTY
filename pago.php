<?php
session_start();
$logeado = isset($_SESSION['usuario_logueado']);
if($logeado){ ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banorte - Transferencia Nacional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body class="min-h-screen">

    <header class="bg-main p-3 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="logo">
                <span class="logo" style="display: flex; justify-content: flex-start; align-items: center;">
                    <a href="paginaprincipal.html">
                        <img src="LogoBanorte.png" alt="Logo Banorte"
                            style="width: 300px; height: 200px; object-fit: contain;">
                    </a>
                </span>
            </div>
            <div class="hidden md:flex space-x-6 text-sm font-semibold text-white">
                <span>Bienvenido(a) <span class="font-bold">USUARIO ADMINISTRADOR - 1555983</span> (Empresa: <span
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
    <main class="max-w-7xl mx-auto p-4 lg:p-8">
        <h1 class="text-lg font-bold text-main mb-4">Otros Bancos Nacionales</h1>

        <div class="border border-gray-300 p-6 bg-white shadow-md">
            <div class="flex justify-between items-center mb-4 border-b border-main pb-2">
                <h2 class="text-base font-bold text-gray-700">Ficha de Transferencia</h2>
                <span class="text-xs text-gray-500">PASO 1 DE 1</span>
            </div>

            <form class="space-y-3" method="POST" action="php/registrar_transaccion.php">
                <!-- Cuenta Origen -->
                <div class="grid grid-cols-12 items-center gap-4 relative">
                    <label class="form-label col-span-3 text-right">Cuenta Origen:</label>
                    <div class="col-span-6 input-floating relative">
                        <input type="text" id="cuenta_origen" name="cuenta_origen" class="form-input-select" required>
                        <label for="cuenta_origen">Escriba su cuenta origen</label>
                        <div class="clear-btn" data-target="cuenta_origen">×</div>
                    </div>
                </div>

                <!-- CLABE o Destino -->
                <div class="grid grid-cols-12 items-center gap-4 relative">
                    <label class="form-label col-span-3 text-right">CLABE o Destino:</label>
                    <div class="col-span-6 input-floating relative">
                        <input type="text" id="clabe_destino" name="clabe_destino" class="form-input-select" required>
                        <label for="clabe_destino">Ingrese CLABE o número de tarjeta</label>
                        <div class="clear-btn" data-target="clabe_destino">×</div>
                    </div>
                </div>

                <!-- Importe -->
                <div class="grid grid-cols-12 items-center gap-4 relative">
                    <label class="form-label col-span-3 text-right">Importe a Transferir:</label>
                    <div class="col-span-2 input-floating relative">
                        <input type="text" id="importe" name="importe" class="form-input-select text-right" required>
                        <label for="importe">0.00</label>
                        <div class="clear-btn" data-target="importe">×</div>
                    </div>
                    <span class="text-gray-600 text-sm col-span-1">MXN</span>
                </div>

                <!-- Número de Referencia -->
                <div class="grid grid-cols-12 items-center gap-4 relative">
                    <label class="form-label col-span-3 text-right">Número de Referencia:</label>
                    <div class="col-span-2 input-floating relative">
                        <input type="text" id="referencia" name="referencia" class="form-input-select">
                        <label for="referencia">1234567</label>
                        <div class="clear-btn" data-target="referencia">×</div>
                    </div>
                    <span class="text-xs text-main col-span-4">(7 caracteres numéricos)</span>
                </div>

                <!-- Concepto de Pago -->
                <div class="grid grid-cols-12 items-center gap-4 relative">
                    <label class="form-label col-span-3 text-right">Concepto de Pago:</label>
                    <div class="col-span-3 input-floating relative">
                        <input type="text" id="concepto" name="concepto" class="form-input-select" required>
                        <label for="concepto">Ej. Pago de servicios</label>
                        <div class="clear-btn" data-target="concepto">×</div>
                    </div>
                </div>

                <!-- Fecha de Operación -->
                <div class="grid grid-cols-12 items-center gap-4">
                    <label class="form-label col-span-3 text-right">Fecha de Operación:</label>
                    <div class="col-span-3 flex items-center space-x-2 input-floating relative">
                        <input type="date" id="fecha_operacion" name="fecha_operacion" class="form-input-select w-full" required>
                        <label for="fecha_operacion">Seleccione fecha</label>
                    </div>
                </div>
            

            <style>
                .input-floating {
                    position: relative;
                }

                .input-floating input {
                    width: 100%;
                    padding: 14px 8px 6px;
                    /* más espacio arriba para la label */
                    font-size: 16px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                }

                .input-floating label {
                    position: absolute;
                    left: 8px;
                    top: 10px;
                    /* empieza más arriba */
                    font-size: 12px;
                    /* más pequeño desde el inicio */
                    pointer-events: none;
                    transition: 0.2s ease all;
                    background-color: transparent;
                    padding: 0 2px;
                    /* evita que el texto se empalme con el borde */
                }

                /* Floating effect: cuando el input tiene foco o contenido */
                .input-floating input:focus+label,
                .input-floating input:not(:placeholder-shown)+label,
                .input-floating input:valid+label {
                    top: 2px;
                    /* más cerca del borde superior */
                    font-size: 10px;
                    /* aún más pequeño al flotar */
                    transform: none;
                }
            </style>


            <div class="mt-8 border-t border-gray-300 pt-4 flex justify-between items-center">
                <span class="text-xs text-gray-500">Campos requeridos y obligatorios</span>
                <button type="submit" class="btn" id="primario">Continuar</button>
            </div>
            </form>
        </div>
    </main>

    <script>
        // Mostrar/ocultar botón "x" dinámicamente
        document.querySelectorAll('.form-input-select').forEach(input => {
            const clearBtn = document.querySelector(`.clear-btn[data-target="${input.id}"]`);
            if (!clearBtn || input.type === 'date') return; // Evitar para fecha

            input.addEventListener('input', () => {
                clearBtn.style.visibility = input.value ? 'visible' : 'hidden';
            });

            clearBtn.addEventListener('click', () => {
                input.value = '';
                clearBtn.style.visibility = 'hidden';
                input.focus();
            });
        });
    </script>
</body>

</html>
<?php }else{
    header("Location: paginaprincipal.php"); 
    exit;}?>