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

## Testando os Endpoints com Postman
- Você pode utilizar o [Postman](https://www.postman.com/) para testar os endpoints descritos acima.
- Para cada endpoint, envie as requisições HTTP adequadas (GET, POST, PUT, DELETE) com os parâmetros e payloads apropriados.

## Documentação
- A documentação detalhada dos endpoints foi feita utilizando o Postman e pode ser visualizada no arquivo `docs/api-documentation.json`.

## Relatório Técnico
- O relatório técnico, explicando como a aplicação foi desenvolvida, incluindo os desafios encontrados e as soluções adotadas, está disponível no arquivo `docs/relatorio_tecnico.pdf`.
