import BuscaApi from '../lib/BuscaApiG.js';
import Mensagem from '../lib/Mensagens.js';
export default class CadSaloes {
    constructor(navigateCallback) {
        this.navigate = navigateCallback;
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.mensagem = new Mensagem();
    }
    async init() {
       
    }

    async cadastrar(salao) {
        try {
            const data = await this.buscaApi.fetchApi('Saloes', 'POST', salao);
            if (data.status) {
                this.displayMessage('Salão registrado com sucesso!');
                const salao = data.idSalao;
                this.navigate('cadendereco', salao );
            } else {
                this.displayMessage(`Erro ao registrar o Salão. ${data.message}`);
            }
        } catch (error) {
            console.error('Erro ao registrar:', error);
            this.displayMessage(`Erro ao registrar o Salão.${data.message}`);
        }
    }

    displayMessage(message) {
        const messageElement = document.getElementById('message');
        messageElement.textContent = message;
    }

    render() {
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';

        const registrationContainer = document.createElement('div');
        registrationContainer.className = 'registration-container';

        registrationContainer.innerHTML = `
        <div class="w3-container">
      
        <div id="id01" class="w3-modal" style="display:block">
          <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
            <form class="w3-container" id="salaoForm">
                <div class="w3-section">
                <label for="titulo">Titulo</label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="titulo" id="titulo" placeholder="Insira um Titulo para o negócio" required />
                </div>
                <div class="w3-section">
                <label for="Serviços">Servicos</label>
                <textarea class="w3-input w3-border" style="resize:none" maxlength="300" name="servicos" id="servicos" placeholder="Insira os Serviços separados por vírgula ex.\n  corte de cabelo, luzes, depilação"></textarea>
                <div id="contador">Caracteres restantes: 300</div>
                </div>
                <button id="cancelar" class="w3-button  w3-red w3-section w3-padding">Cancelar</button>
                <button type="submit" class="w3-button  w3-green w3-section w3-padding">Cadastrar</button>
                <p id="message"></p>
            </form>
           
            </div>
            </div>
            </div>
        `;
        registrationContainer.querySelector('#servicos').addEventListener('keyup', async (e) => {

            document.getElementById('contador').textContent = `Caracteres restantes: ${300 - e.target.value.length}`;
        });
        registrationContainer.querySelector('#cancelar').addEventListener('click', async (e) => {
            this.navigate('gerirsaloes');
        });

        registrationContainer.querySelector('#salaoForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            let salao = {};
            const elements = registrationContainer.querySelector('#salaoForm').elements;
        
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                if (element.name && element.value) {
                    salao[element.name] = element.value;
                }
            }
            if (salao.titulo=='') {
                this.displayMessage("Insira um titulo e serviços");
                return;
            }
            const isConfirmed = await this.mensagem.confirmAction('create');
                    if (isConfirmed) {
                        await this.cadastrar(salao);
                    }
        });

        
         mainDiv.appendChild(registrationContainer);
        return {
            element: mainDiv,
            init: () => {}
        };
    }
}

// const saloes = new CadSaloes();
// const renderedElement = saloes.render();
// saloes.init();
// document.body.appendChild(renderedElement.element);