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
html, body, #app { height: 100%; width: 100%; margin: 0; padding: 0; }

ul li {
  color: #ffea72; /* amarelo igual ao título */
  font-weight: bold; /* opcional, fica mais bonito */
}

body {
  background: #b35304;
  font-family: Arial, sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
}

#app {
  display: flex; justify-content: center; align-items: center; width: 100%;
}

.visual {
  background: rgb(80, 78, 78);
  padding: 20px;
  border-radius: 10px;
  max-width: 500px;
  width: 100%;
  box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}

h1, h2 { color: #c27f49; text-align: center; }

.cadastro { margin-bottom: 16px; }
.campo {
  width: 90%;                 /* ENCORTA o campo inteiro */
  margin: 0 auto 16px auto;   /* centraliza */
  position: relative;
}


.campo input {
  width: 100%;                /* input acompanha o tamanho do campo */
  padding: 12px 8px 8px 8px;
  border: 0;
  border-radius: 4px;
  background: #fff;
  font-size: 16px;
  color: #000000;
}


.campo input::placeholder { color: transparent; }

.campo label {
  position: absolute; top: 12px; left: 10px;
  color: #000000; pointer-events: none; transition: 0.2s ease;
  background: transparent;
}

.campo input:focus + label,
.campo input:not(:placeholder-shown) + label {
  top: -8px; left: 8px; background: #b35304; font-size: 12px; padding: 0 4px; color: #fff;
}

button {
  display: block; margin: 12px auto 0 auto; padding: 8px 12px;
  background: #fff; color: #000; border: none;
  border-radius: 4px; cursor: pointer; transition: all 0.2s ease;
}
button:hover { background: #b35304; transform: scale(1.08); box-shadow: 0 4px 10px #fff; }

</style>
