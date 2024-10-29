Vue.component('produto-log-manager', {
    template: `
        <div>
            <h1>Gerenciamento de Produtos</h1>
            <form @submit.prevent="criarProduto">
                <input v-model="novoProduto.nome" placeholder="Nome" required>
                <input v-model="novoProduto.descricao" placeholder="Descrição" required>
                <input v-model="novoProduto.preco" type="number" placeholder="Preço" required>
                <input v-model="novoProduto.estoque" type="number" placeholder="Estoque" required>
                <button type="submit">Criar Produto</button>
                <button @click.prevent="cancelar">Cancelar</button>
            </form>

            <h2>Lista de Produtos</h2>
            <ul>
                <li v-for="produto in produtos" :key="produto.id">
                    {{ produto.nome }} - {{ produto.descricao }} - R$ {{ produto.preco }} - Estoque: {{ produto.estoque }}
                    <button @click="editarProduto(produto)">Editar</button>
                    <button @click="deletarProduto(produto.id)">Deletar</button>
                </li>
            </ul>

            <h2>Logs</h2>
            <ul>
                <li v-for="log in logs" :key="log.id">
                    {{ log.message }} - {{ log.timestamp }}
                </li>
            </ul>
        </div>
    `,
    data() {
        return {
            produtos: [],
            logs: [],
            novoProduto: {
                nome: '',
                descricao: '',
                preco: 0,
                estoque: 0
            }
        };
    },
    mounted() {
        this.carregarProdutos();
        this.carregarLogs();
    },
    methods: {
        carregarProdutos() {
            fetch('api/produtos')
                .then(response => response.json())
                .then(data => {
                    console.log('Produtos carregados:', data);
                    this.produtos = data.data || [];
                })
                .catch(error => console.error('Erro ao carregar produtos:', error));
        },
        carregarLogs() {
            fetch('api/logs')
                .then(response => response.json())
                .then(data => {
                    console.log('Logs carregados:', data);
                    this.logs = data.data || [];
                })
                .catch(error => console.error('Erro ao carregar logs:', error));
        },
        criarProduto() {
            fetch('api/produtos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.novoProduto)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Produto criado:', data);
                this.carregarProdutos();
                this.novoProduto = { nome: '', descricao: '', preco: 0, estoque: 0 };
            })
            .catch(error => console.error('Erro ao criar produto:', error));
        },
        editarProduto(produto) {
            const novoNome = prompt('Novo nome:', produto.nome);
            const novaDescricao = prompt('Nova descrição:', produto.descricao);
            const novoPreco = prompt('Novo preço:', produto.preco);
            const novoEstoque = prompt('Novo estoque:', produto.estoque);

            if (novoNome && novaDescricao && novoPreco !== null && novoEstoque !== null) {
                const produtoAtualizado = { 
                    ...produto, 
                    nome: novoNome, 
                    descricao: novaDescricao, 
                    preco: parseFloat(novoPreco), 
                    estoque: parseInt(novoEstoque) 
                };

                fetch(`api/produtos/${produto.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(produtoAtualizado)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Produto atualizado:', data);
                    this.carregarProdutos();
                })
                .catch(error => console.error('Erro ao atualizar produto:', error));
            }
        },
        deletarProduto(produtoId) {
            if (confirm('Tem certeza que deseja deletar este produto?')) {
                fetch(`api/produtos/${produtoId}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Produto deletado:', data);
                    this.carregarProdutos();
                })
                .catch(error => console.error('Erro ao deletar produto:', error));
            }
        },
        cancelar() {
            this.novoProduto = { nome: '', descricao: '', preco: 0, estoque: 0 };
        }
    }
});

new Vue({
    el: '#app'
});
