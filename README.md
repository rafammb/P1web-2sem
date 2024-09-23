# Sistema de Gerenciamento de Produtos com Logs

## Descrição do Projeto
Este projeto é uma API que permite gerenciar produtos e registrar logs de operações CRUD (criação, atualização e exclusão). A aplicação foi desenvolvida utilizando **Python**, **Flask**, e um banco de dados **SQLite**.

## Funcionalidades
- **CRUD de Produtos**: Possibilidade de criar, ler, atualizar e deletar produtos.
- **Registro de Logs**: Sempre que um produto é criado, atualizado ou excluído, a operação é registrada em uma tabela de logs.
- **Validação de dados**: Regras de validação para garantir que o nome do produto, preço e estoque sejam inseridos corretamente.
- **Consulta de Logs**: Possibilidade de visualizar todos os logs de operações realizadas.

## Estrutura do Banco de Dados

### Tabela `Produto`
```sql
CREATE TABLE Produto (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL CHECK (LENGTH(nome) >= 3),
    descricao TEXT,
    preco REAL NOT NULL CHECK (preco > 0),
    estoque INTEGER NOT NULL CHECK (estoque >= 0),
    userInsert TEXT NOT NULL,
    data_hora TEXT DEFAULT (datetime('now', 'localtime'))
);

Coluna	Tipo	Descrição
id	INTEGER	Chave primária autoincrementável.
nome	TEXT	Nome do produto (mínimo 3 caracteres).
descricao	TEXT	Descrição do produto (opcional).
preco	REAL	Preço do produto (deve ser positivo).
estoque	INTEGER	Quantidade de estoque (deve ser >= 0).
userInsert	TEXT	Usuário que realizou a operação.
data_hora	TEXT	Data e hora de criação do produto (formato YYYY-MM-DD HH:MM:SS).
Tabela Log
sql
Copiar código
CREATE TABLE Log (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    acao TEXT NOT NULL,
    data_hora TEXT DEFAULT (datetime('now', 'localtime')),
    produto_id INTEGER NOT NULL,
    userInsert TEXT NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES Produto(id) ON DELETE CASCADE
);
Coluna	Tipo	Descrição
id	INTEGER	Chave primária autoincrementável.
acao	TEXT	Ação realizada (criado, atualizado, excluído).
data_hora	TEXT	Data e hora da ação (formato YYYY-MM-DD HH:MM:SS).
produto_id	INTEGER	ID do produto afetado (chave estrangeira para a tabela Produto).
userInsert	TEXT	Usuário que realizou a ação.
Endpoints da API
Endpoints de Produtos
GET /produtos: Retorna todos os produtos.
GET /produtos/{id}: Retorna o produto com o ID especificado.
POST /produtos: Cria um novo produto. Exemplo de corpo da requisição:
json
Copiar código
{
    "nome": "Produto X",
    "descricao": "Descrição do produto X",
    "preco": 100.50,
    "estoque": 20,
    "userInsert": "admin"
}
PUT /produtos/{id}: Atualiza um produto existente. Exemplo de corpo da requisição:
json
Copiar código
{
    "nome": "Produto X",
    "descricao": "Nova descrição",
    "preco": 110.00,
    "estoque": 15,
    "userInsert": "admin"
}
DELETE /produtos/{id}: Exclui o produto com o ID especificado.
Endpoints de Logs
GET /logs: Retorna todos os logs das operações realizadas nos produtos.
Como Executar o Projeto
Clone o repositório:

bash
Copiar código
git clone https://github.com/seu-usuario/nome-do-repositorio.git
Instale as dependências:

bash
Copiar código
pip install -r requirements.txt
Crie o banco de dados utilizando o DB Browser for SQLite ou executando o seguinte comando no terminal:

bash
Copiar código
sqlite3 banco_de_dados.db < schema.sql
Execute a aplicação:

bash
Copiar código
python app.py
Acesse a API através de http://localhost:5000.

Testando os Endpoints com Postman
Você pode utilizar o Postman para testar os endpoints descritos acima.
Para cada endpoint, envie as requisições HTTP adequadas (GET, POST, PUT, DELETE) com os parâmetros e payloads apropriados.
Documentação
A documentação detalhada dos endpoints foi feita utilizando o Postman e pode ser visualizada no arquivo docs/api-documentation.json.
Relatório Técnico
O relatório técnico, explicando como a aplicação foi desenvolvida, incluindo os desafios encontrados e as soluções adotadas, está disponível no arquivo docs/relatorio_tecnico.pdf.
perl
Copiar código

Esse formato está pronto para ser copiado e colado diretamente no **README.md
