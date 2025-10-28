const API = "http://localhost/envios/api.php";

const form = document.getElementById("formEnvio");
const tbody = document.querySelector("#tabla tbody");
let editId = null;

async function listarEnvios() {
  const res = await fetch(`${API}?action=listar`);
  const data = await res.json();
  tbody.innerHTML = data.map(e => `
    <tr>
      <td>${e.id}</td>
      <td>${e.destinatario}</td>
      <td>${e.direccion}</td>
      <td>${e.descripcion}</td>
      <td>
        <button onclick="editarEnvio(${e.id}, '${e.destinatario}', '${e.direccion}', '${e.descripcion}')">✏️</button>
        <button onclick="eliminarEnvio(${e.id})">🗑️</button>
      </td>
    </tr>
  `).join("");
}

form.addEventListener("submit", async e => {
  e.preventDefault();
  const envio = {
    destinatario: form.destinatario.value,
    direccion: form.direccion.value,
    descripcion: form.descripcion.value
  };
  
  if (editId) {
    envio.id = editId;
    await fetch(`${API}?action=modificar`, {
      method: "PUT",
      body: JSON.stringify(envio)
    });
    editId = null;
  } else {
    await fetch(`${API}?action=crear`, {
      method: "POST",
      body: JSON.stringify(envio)
    });
  }
  
  form.reset();
  listarEnvios();
});

function editarEnvio(id, dest, dir, desc) {
  editId = id;
  form.destinatario.value = dest;
  form.direccion.value = dir;
  form.descripcion.value = desc;
}

async function eliminarEnvio(id) {
  if (confirm("¿Seguro deseas eliminar este envío?")) {
    await fetch(`${API}?action=eliminar&id=${id}`, { method: "DELETE" });
    listarEnvios();
  }
}

listarEnvios();
