Sistema de Gerenciamento de Produtos com Logs
Descrição do Projeto
Este projeto é uma API que permite gerenciar produtos e registrar logs de operações CRUD (criação, atualização e exclusão). A aplicação foi desenvolvida utilizando Python, Flask, e um banco de dados SQLite.

Funcionalidades
CRUD de Produtos: Possibilidade de criar, ler, atualizar e deletar produtos.
Registro de Logs: Sempre que um produto é criado, atualizado ou excluído, a operação é registrada em uma tabela de logs.
Validação de dados: Regras de validação para garantir que o nome do produto, preço e estoque sejam inseridos corretamente.
Consulta de Logs: Possibilidade de visualizar todos os logs de operações realizadas nos produtos.
Estrutura do Banco de Dados
Tabela Produto
Coluna	Tipo	Descrição
id	INTEGER	Chave primária autoincrementável.
nome	TEXT	Nome do produto (mínimo 3 caracteres).
descricao	TEXT	Descrição do produto (opcional).
preco	REAL	Preço do produto (deve ser positivo).
estoque	INTEGER	Quantidade de estoque (deve ser >= 0).
userInsert	TEXT	Usuário que realizou a operação.
data_hora	TEXT	Data e hora de criação do produto (formato YYYY-MM-DD HH:MM:SS).
Tabela Log
Coluna	Tipo	Descrição
id	INTEGER	Chave primária autoincrementável.
acao	TEXT	Ação realizada (criado, atualizado, excluído).
data_hora	TEXT	Data e hora da ação (formato `YYYY-MM
