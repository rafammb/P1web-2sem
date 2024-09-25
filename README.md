# Sistema de Gerenciamento de Produtos

## Descrição
Este projeto é um sistema de gerenciamento de produtos que permite cadastrar, atualizar, listar e excluir produtos. Além disso, todas as operações são registradas em uma tabela de logs para rastreamento e auditoria.

## Funcionalidades
- **Gerenciamento de Produtos**
  - Cadastrar novos produtos.
  - Atualizar informações de produtos existentes.
  - Listar todos os produtos ou um produto específico.
  - Excluir produtos do sistema.

- **Registro de Logs**
  - Todas as operações CRUD são registradas com informações detalhadas, como tipo de operação, data e hora, e ID do produto afetado.

## Tecnologias Utilizadas
- **Banco de Dados**: SQLite
- **Backend**: PHP
- **Documentação da API**: Postman

## Endpoints

### Produtos
- **GET /produtos**
  - Retorna todos os produtos.
  
- **GET /produtos/{id}**
  - Retorna o produto com o ID especificado.
  
- **POST /produtos**
  - Cria um novo produto (com validação de campos).
  
- **PUT /produtos/{id}**
  - Atualiza os dados de um produto existente (com validação de campos).
  
- **DELETE /produtos/{id}**
  - Exclui o produto com o ID especificado.

#### Validações de Produtos
- O nome do produto deve ter no mínimo 3 caracteres.
- O preço deve ser um valor positivo.
- O estoque deve ser um número inteiro maior ou igual a zero.

### Logs
- **GET /logs**
  - Retorna todos os logs das operações realizadas nos produtos.

## Documentação da API
A documentação detalhada da API está disponível no Postman e inclui:
- Descrição dos endpoints.
- Parâmetros de entrada.
- Exemplos de requisições e respostas.
- Códigos de status esperados (200, 400, 404, 500).

## Testes
Todos os endpoints foram testados utilizando o Postman, e as capturas de tela dos testes estão incluídas no documento de entrega.

## Relatório Técnico
O sistema é organizado em várias classes e um arquivo index.php que atua como o ponto de entrada da aplicação. As principais partes do sistema incluem:

## Modelos (Models):
Contêm as classes que representam a estrutura dos dados e a lógica para interagir com o banco de dados.

## Produto:
Classe responsável pelas operações relacionadas aos produtos.
Log: Classe responsável por registrar as operações realizadas.
Controladores (Controllers): Contêm as classes que gerenciam as interações entre os modelos e a lógica do aplicativo.

## ProdutoController: 
Controlador que gerencia as operações de produtos, utilizando a classe Produto.

## LogController: Controlador que gerencia as operações de log.
Configuração do Banco de Dados (Database): Contém a lógica para conectar ao banco de dados SQLite.

## Ponto de Entrada (index.php): 
Arquivo que processa as requisições e direciona as chamadas para as funções apropriadas.

A classe Log foi criada para interagir com a tabela de logs no banco de dados.
Ela possui métodos para registrar logs, listar todos os logs e buscar logs por ID. Cada log contém informações como a ação realizada (criação, atualização ou exclusão), o ID do produto afetado, o usuário que realizou a operação e a data e hora da operação.

A classe LogController gerencia as operações relacionadas aos logs, como listar todos os logs e buscar um log específico por ID.

## Registro de Logs:

Sempre que uma operação de criação, atualização ou exclusão de produto é realizada no ProdutoController, um log correspondente é registrado chamando o método registrar da classe Log. Isso garante que todas as ações relevantes sejam registradas no banco de dados.

## Validação dos Campos

Validação na Criação de Produtos:

Antes de inserir um novo produto no banco de dados, o sistema verifica se todos os campos obrigatórios estão presentes e se os valores são válidos.
Por exemplo, o nome do produto deve ter no mínimo 3 caracteres, o preço deve ser um valor positivo e o estoque deve ser um número inteiro maior ou igual a zero.

Validação na Atualização de Produtos:

A validação na atualização segue a mesma lógica, garantindo que os dados a serem atualizados atendam aos critérios estabelecidos.

## Conclusão

Durante o desenvolvimento, enfrentamos alguns desafios, como entender todas as regras de validação e garantir que os logs estivessem sendo registrados corretamente. Teve aquele momento em que a API não respondia como esperávamos, e tivemos que caçar o problema. Como estávamos sob um prazo apertado, isso complicou um pouco, mas conseguimos nos organizar e dividir as tarefas, o que ajudou bastante.

Além disso, pela nossa falta de experiência, o projeto demorou mais do que o esperado. Mas, no fim das contas, cada desafio foi uma ótima oportunidade de aprendizado. Aprendemos a pesquisar mais, pedir ajuda quando necessário e, claro, a importância de uma boa comunicação na equipe. No geral, estamos felizes com o resultado e achamos que a aplicação realmente poderia ajudar na gestão dos produtos!

Creio que implementamos tudo o que foi pedido, não acredito que tenha sido feita da melhor porém houve um grande esforço por parte da nossa dupla. A curva de aprendizagem realizando esse projeto foi de certa forma boa, mesmo com nossa inexperiência desconhecimento conseguimos realizar o projeto. No geral foi um projeto bom, muito difícil de ser completo confesso, tivemos que nos adentrar em diversas pesquisas e conceitos que não tínhamos entendido mas conseguimos. A parte mais complexa do projeto foi a implementação dos endpoints e solucionar os seus, tomou uma grande parte do nosso tempo, o Postman também foi um empecilho, nosso conhecimento sobre sendo totalmente negativo, não tínhamos conhecimento algum sobre as funcionalidades, apenas o conceito, e maquina em que fizemos nossa API não ajudou muito pois travou diversas vezes no Postman
