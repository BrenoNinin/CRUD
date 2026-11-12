# CRUD de Usuários — Vue.js + Laravel + MySQL

Projeto de gerenciamento de usuários desenvolvido com Vue.js no frontend, Laravel no backend e MySQL como banco de dados.

## Funcionalidades

- Cadastrar usuários.
- Listar usuários.
- Editar usuários.
- Excluir usuários.

## Tecnologias utilizadas

- Vue.js
- Laravel
- PHP
- MySQL
- Axios
- JavaScript

## Como executar o projeto

### Backend

Entre na pasta `backend`:

```bash
composer install
```

Configure o arquivo `.env` com os dados de conexão do MySQL e execute:

```bash
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend

Entre na pasta `frontend`:

```bash
npm install
npm run dev
```

## Autor

Breno Ninin