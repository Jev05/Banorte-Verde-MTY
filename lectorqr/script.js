function domReady(fn) {
  if (document.readyState === "complete" || document.readyState === "interactive") {
    setTimeout(fn, 1);
  } else {
    document.addEventListener("DOMContentLoaded", fn);
  }
}

domReady(function () {
  const splash = document.getElementById("splash-screen");
  const qrResult = document.getElementById("you-qr-result");
  const form = document.getElementById("form-datos");
  const cantidadInput = document.getElementById("cantidad");
  const enviarBtn = document.getElementById("enviar");
  const mensaje = document.getElementById("mensaje");
  const card = document.getElementById("card-container");

  let correoDesencriptado = "";
  let lastResult = null;

  setTimeout(() => splash.classList.add("hidden"), 2800);

  function onScanSuccess(decodeText) {
    if (decodeText !== lastResult) {
      lastResult = decodeText;
      try {
        correoDesencriptado = atob(decodeText);
      } catch {
        alert("El código QR no contiene un correo ");
        return;
      }

      qrResult.innerHTML = `Correo escaneado: <b>${correoDesencriptado}</b>`;
      form.style.display = "block";

      card.classList.add("glow");
      setTimeout(() => card.classList.remove("glow"), 2000);
    }
  }

  const htmlscanner = new Html5QrcodeScanner("my-qr-reader", { fps: 10, qrbox: 250 });
  htmlscanner.render(onScanSuccess);

  enviarBtn.addEventListener("click", function () {
    const cantidad = cantidadInput.value.trim();

    if (!cantidad || cantidad <= 0) {
      mensaje.textContent = "El campo es obligatorio";
      mensaje.style.color = "#EB0029";
      return;
    }

    mensaje.textContent = "Enviando...";
    mensaje.style.color = "#5B6670";
    enviarBtn.classList.add("sending");
    setTimeout(() => enviarBtn.classList.remove("sending"), 600);

    fetch("../insertar_botellas.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        correo: correoDesencriptado,
        cantidad: parseInt(cantidad),
      }),
    })
      .then((res) => res.text())
      .then((text) => {
        try {
          const data = JSON.parse(text);
          if (data.success) {
            mensaje.textContent = data.message;
            mensaje.style.color = "green";
            cantidadInput.value = "";
            card.classList.add("glow");
            setTimeout(() => card.classList.remove("glow"), 2000);
          } else {
            mensaje.textContent = "Error: " + data.message;
            mensaje.style.color = "#EB0029";
          }
        } catch {
          mensaje.textContent = "Respuesta inválida del servidor";
          mensaje.style.color = "#EB0029";
        }
      })
      .catch((err) => {
        mensaje.textContent = "Error de conexión: " + err.message;
        mensaje.style.color = "#EB0029";
      });
  });
});
