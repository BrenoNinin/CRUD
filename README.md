CRUD com Vue.js e Laravel

Este projeto é um CRUD simples de usuários feito com Vue.js no frontend e Laravel no backend. Ele permite cadastrar, listar, editar e excluir usuários. Os dados não ficam gravados em banco de dados, e sim na memória usando sessão do Laravel, atendendo ao requisito de “banco de dados em memória”.

O frontend foi desenvolvido em Vue.js, com um formulário para inserir nome, email, telefone e senha, além de uma lista que mostra todos os usuários cadastrados. Também é possível editar um usuário, carregar os dados dele no formulário e salvar as alterações, ou excluir um usuário da lista.

O backend foi feito com Laravel, criando rotas específicas na API para listar, criar, atualizar e deletar usuários. O Vue.js se comunica com o Laravel usando Axios, enviando e recebendo dados em JSON. Cada alteração na interface reflete imediatamente no backend.

Também foi criado um planejamento no Azure DevOps com as tarefas básicas do projeto, incluindo criação do ambiente, desenvolvimento do frontend, desenvolvimento do backend, integração dos dois lados, documentação e vídeo de apresentação.

O projeto atende ao objetivo do desafio, funcionando de forma local com comunicação entre Vue.js e Laravel, CRUD completo e documentação simples.

Autor: Breno Ninin
