<template>
  <div class="visual">
    <h1>Cadastro de Usuários</h1>

    <form class="cadastro" @submit.prevent="editando ? atualizarUsuario() : adicionarUsuario()">
      <div class="campo">
        <input type="text" v-model="novo.nome" placeholder=" " required />
        <label>Nome</label>
      </div>

      <div class="campo">
        <input type="email" v-model="novo.email" placeholder=" " required />
        <label>E-mail</label>
      </div>

      <div class="campo">
        <input type="text" v-model="novo.telefone" placeholder=" " required />
        <label>Telefone</label>
      </div>

      <div class="campo">
        <input type="password" v-model="novo.senha" placeholder=" " required />
        <label>Senha</label>
      </div>

      <button type="submit">
        {{ editando ? "Atualizar" : "Salvar" }}
      </button>

      <button v-if="editando" type="button" @click="cancelarEdicao" style="background:#ccc;">
        Cancelar
      </button>
    </form>

    <h2>Usuários Cadastrados</h2>
    <ul>
      <li v-for="(usuario, i) in usuarios" :key="usuario.id">
        {{ usuario.nome }} - {{ usuario.email }} - {{ usuario.telefone }}

        <button @click="editarUsuario(usuario)">Editar</button>
        <button @click="removerUsuario(i)">Excluir</button>
      </li>

      <li v-if="usuarios.length === 0" class="vazio">
        Nenhum usuário cadastrado.
      </li>

    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const API = 'http://127.0.0.1:8000/api/usuarios'
axios.defaults.withCredentials = false

const usuarios = ref([])
const novo = ref({ nome: '', email: '', telefone: '', senha: '' })

// Controle da edição
const editando = ref(false)
const editId = ref(null)

// Listar
onMounted(async () => {
  const { data } = await axios.get(API)
  usuarios.value = data
})

// Criar novo usuário
async function adicionarUsuario() {
  try {
    const payload = { ...novo.value }
    const { data } = await axios.post(API, payload)
    usuarios.value.push(data)

    novo.value = { nome: '', email: '', telefone: '', senha: '' }
  } catch (e) {
    console.error("Erro ao salvar:", e)
  }
}

// Atualizar existente
async function atualizarUsuario() {
  try {
    const payload = { ...novo.value };

    const { data } = await axios.put(`${API}/${editId.value}`, payload);

    const idx = usuarios.value.findIndex(u => u.id === editId.value);
    usuarios.value[idx] = data;

    editando.value = false;
    editId.value = null;

    novo.value = { nome: '', email: '', telefone: '', senha: '' };
  } catch (e) {
    console.error("Erro ao atualizar:", e);
    alert("Erro ao atualizar");
  }
}



// Iniciar edição
function editarUsuario(usuario) {
  editando.value = true
  editId.value = usuario.id

  novo.value = {
    nome: usuario.nome,
    email: usuario.email,
    telefone: usuario.telefone,
    senha: usuario.senha
  }
}

// Cancelar edição
function cancelarEdicao() {
  editando.value = false
  editId.value = null
  novo.value = { nome: '', email: '', telefone: '', senha: '' }
}

// Remover
async function removerUsuario(index) {
  const id = usuarios.value[index].id
  await axios.delete(`${API}/${id}`)
  usuarios.value.splice(index, 1)
}
</script>

<style>

/* ===== BASE ===== */

* {
  box-sizing: border-box;
}

html, body, #app {
  width: 100%;
  min-height: 100%;
  margin: 0;
}

body {
  min-height: 100vh;
  font-family: "Segoe UI", Arial, sans-serif;
  color: #e5e7eb;
  background: radial-gradient(ellipse at top, #263449, #10151f 60%);
}

#app {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 30px 15px;
}

/* ===== CARD ===== */

.visual {
  width: 100%;
  max-width: 540px;
  padding: 35px;
  background: linear-gradient(145deg, #222e3e, #192331);
  border: 1px solid #354255;
  border-top: 2px solid #789bc5;
  border-radius: 14px;
  box-shadow: 0 25px 60px #0005;
}

.visual::before {
  content: "PAINEL DE USUÁRIOS";
  display: table;
  margin: 0 auto 16px;
  padding: 6px 12px;
  color: #93b8e6;
  background: #6090c21a;
  border: 1px solid #789bc533;
  border-radius: 20px;
  font-size: 10px;
  font-weight: bold;
  letter-spacing: 1.5px;
}

/* ===== TÍTULOS ===== */

h1, h2 {
  text-align: center;
}

h1 {
  color: #f8fafc;
  font-size: 27px;
  margin: 0 0 32px;
}

h1::after {
  content: "";
  display: block;
  width: 42px;
  height: 3px;
  margin: 13px auto 0;
  border-radius: 5px;
  background: #789bc5;
}

h2 {
  color: #d5dfed;
  font-size: 18px;
  margin: 35px 0 22px;
}

/* ===== FORMULÁRIO ===== */

.campo {
  position: relative;
  margin-bottom: 18px;
}

.campo input {
  width: 100%;
  height: 49px;
  padding: 14px;
  background: #151d29;
  border: 1px solid #3b4a5e;
  border-radius: 8px;
  color: #f1f5f9;
  font-size: 15px;
  outline: none;
  transition: .2s;
}

.campo input::placeholder {
  color: transparent;
}

.campo input:focus {
  border-color: #8eb5e5;
  box-shadow: 0 0 0 3px #7da6d820;
}

.campo label {
  position: absolute;
  top: 14px;
  left: 14px;
  color: #94a3b8;
  pointer-events: none;
  background: #151d29;
  transition: .2s;
}

.campo input:focus + label,
.campo input:not(:placeholder-shown) + label {
  top: -8px;
  left: 10px;
  padding: 0 5px;
  font-size: 12px;
  color: #93b8e6;
}

/* ===== BOTÕES ===== */

button {
  padding: 10px 15px;
  border: 1px solid transparent;
  border-radius: 7px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  transition: .2s;
}

.cadastro button[type="submit"] {
  width: 100%;
  margin-top: 7px;
  background: linear-gradient(135deg, #7099c8, #527ba9);
  color: white;
}

.cadastro button[type="submit"]:hover {
  filter: brightness(1.15);
  transform: translateY(-2px);
}

.cadastro button[type="button"] {
  display: block;
  width: 100%;
  margin-top: 10px;
  background: #354255 !important;
  color: white;
}

/* ===== USUÁRIOS ===== */

ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

ul li {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
  gap: 10px;
  padding: 15px;
  margin-bottom: 11px;
  background: #151e2b;
  border: 1px solid #354255;
  border-radius: 9px;
  color: #dbe4ef;
  font-size: 14px;
  overflow-wrap: anywhere;
  transition: .2s;
}

ul li:hover {
  background: #202f42;
  border-color: #668dbd;
  transform: translateY(-2px);
}

ul li button {
  flex-shrink: 0;
  white-space: nowrap;
}

ul li button:first-of-type {
  margin-left: auto;
  background: #283d56;
  color: #a9c9ee;
  border-color: #3d5878;
}

ul li button:last-of-type {
  background: #472e36;
  color: #e8a8b1;
  border-color: #68414c;
}

ul li button:first-of-type:hover {
  background: #344f70;
}

ul li button:last-of-type:hover {
  background: #603943;
}

/* ===== RESPONSIVIDADE ===== */

@media (max-width: 550px) {
  #app {
    align-items: flex-start;
  }

  .visual {
    padding: 25px 18px;
  }

  h1 {
    font-size: 23px;
  }

  ul li {
    gap: 6px;
    padding: 10px;
    font-size: 12px;
  }

  ul li button {
    padding: 8px 9px;
    font-size: 11px;
  }
}

</style>
