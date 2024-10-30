Vue.component('produto-log-manager', {
    template: `
        <div>
            <h1>Gerenciamento de Produtos</h1>

            <h2><a @click.prevent="abrirProdutos" href="#">Lista de Produtos</a></h2>

            <h2>Criar Produto</h2>
            <form @submit.prevent="criarProduto">
                <input v-model="novoProduto.nome" placeholder="Nome" required>
                <input v-model="novoProduto.descricao" placeholder="Descrição" required>
                <input v-model="novoProduto.preco" type="number" placeholder="Preço" required>
                <input v-model="novoProduto.estoque" type="number" placeholder="Estoque" required>
                <button type="submit">Criar Produto</button>
                <button @click.prevent="cancelar">Cancelar</button>
            </form>

            <h2>Identificar Produto para Atualização</h2>
            <form @submit.prevent="buscarProdutoPorId">
                <input type="number" v-model="idProdutoParaAtualizar" placeholder="ID do Produto" required>
                <button type="submit">Buscar Produto</button>
            </form>

            <h2>Atualizar Produto</h2>
            <form v-if="produtoParaAtualizar" @submit.prevent="atualizarProduto">
                <input v-model="produtoParaAtualizar.nome" placeholder="Nome" required>
                <input v-model="produtoParaAtualizar.descricao" placeholder="Descrição" required>
                <input v-model="produtoParaAtualizar.preco" type="number" placeholder="Preço" required>
                <input v-model="produtoParaAtualizar.estoque" type="number" placeholder="Estoque" required>
                <button type="submit">Atualizar Produto</button>
                <button @click.prevent="cancelarAtualizacao">Cancelar</button>
            </form>

            <h2>Excluir Produto pelo ID</h2>
            <form @submit.prevent="deletarProdutoPorId">
                <label for="produtoId">ID do Produto:</label>
                <input type="number" v-model="produtoId" placeholder="Digite o ID do produto" required>
                <button type="submit">Excluir Produto</button>
            </form>

            <h2><a @click.prevent="abrirLogs" href="#">Logs</a></h2>

            <h2>Buscar Log pelo ID</h2>
            <form @submit.prevent="buscarLogPorId">
                <label for="logId">ID do Log:</label>
                <input type="number" v-model="logId" placeholder="Digite o ID do log" required>
                <button type="submit">Buscar Log</button>
            </form>

            <p v-if="mensagem">{{ mensagem }}</p>
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
                estoque: 0,
                id: null
            },
            idProdutoParaAtualizar: null,
            produtoParaAtualizar: null,
            produtoId: '',
            logId: '',
            mensagem: ''
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
                    this.produtos = data.data || [];
                })
                .catch(error => console.error('Erro ao carregar produtos:', error));
        },
        carregarLogs() {
            fetch('api/logs')
                .then(response => response.json())
                .then(data => {
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
                this.carregarProdutos();
                this.novoProduto = { nome: '', descricao: '', preco: 0, estoque: 0, id: null };
            })
            .catch(error => console.error('Erro ao criar produto:', error));
        },
        buscarProdutoPorId() {
            if (!this.idProdutoParaAtualizar) return;

            fetch(`api/produtos/${this.idProdutoParaAtualizar}`)
                .then(response => {
                    if (!response.ok) throw new Error('Produto não encontrado');
                    return response.json();
                })
                .then(data => {
                    this.produtoParaAtualizar = { ...data, id: this.idProdutoParaAtualizar };
                })
                .catch(error => {
                    this.mensagem = error.message;
                    console.error('Erro ao buscar produto:', error);
                });
        },
        buscarLogPorId() {
            if (!this.logId) {
                this.mensagem = 'Por favor, insira um ID válido!';
                return;
            }
            window.location.href = `api/logs/${this.logId}`;
        },
        atualizarProduto() {
            if (!this.produtoParaAtualizar || !this.produtoParaAtualizar.id) {
                this.mensagem = 'ID do produto não está definido para atualização.';
                return;
            }

            fetch(`api/produtos/${this.produtoParaAtualizar.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(this.produtoParaAtualizar)
            })
            .then(response => response.json())
            .then(data => {
                this.carregarProdutos();
                this.produtoParaAtualizar = null;
                this.mensagem = 'Produto atualizado com sucesso!';
            })
            .catch(error => {
                this.mensagem = 'Erro ao atualizar produto: ' + error.message;
                console.error('Erro ao atualizar produto:', error);
            });
        },
        abrirProdutos() {
            window.location.href = 'api/produtos';
        },
        abrirLogs() {
            window.location.href = 'api/logs';
        },
        deletarProdutoPorId() {
            const id = this.produtoId;
            if (!id) {
                this.mensagem = 'Por favor, insira um ID válido!';
                return;
            }

            fetch(`api/produtos/${id}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (!response.ok) throw new Error('Produto não encontrado ou erro ao deletar');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    this.mensagem = `Produto com ID ${id} excluído com sucesso!`;
                } else {
                    this.mensagem = data.error || 'Erro ao excluir o produto.';
                }
                this.produtoId = '';
                this.carregarProdutos();
            })
            .catch(error => {
                this.mensagem = error.message;
                console.error('Erro ao excluir produto:', error);
            });
        },
        cancelarAtualizacao() {
            this.produtoParaAtualizar = null;
            this.idProdutoParaAtualizar = null;
            this.mensagem = '';
        },
        cancelar() {
            this.novoProduto = { nome: '', descricao: '', preco: 0, estoque: 0, id: null };
            this.mensagem = '';
        }
    }
});

new Vue({
    el: '#app'
});
