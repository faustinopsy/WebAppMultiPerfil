import BuscaApi from '../lib/BuscaApiG.js';

export default class CadEnderecos {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
    }
    async init() {
        await this.buscaEnderecos();
        
    }

    async buscaEnderecos() {
        try {
            const data = await this.buscaApi.fetchApi(`Enderecos`, 'GET');
            //this.renderSaloes(data);
        } catch (error) {
            console.error(error);
        }
    }
    async buscaCep(cep) {
            document.getElementById('rua').value="...";
            document.getElementById('bairro').value="...";
            document.getElementById('cidade').value="...";
            document.getElementById('estado').value="...";
            document.getElementById('latitude').value="...";
            document.getElementById('longitude').value="...";
        try {
            const endereco = await this.buscaApi.fetchCEP(cep, 'GET');
            const rua = endereco.logradouro;
            const cidade = endereco.localidade;
            const geo = `${rua},${cidade}`;
            const dados = await this.buscaApi.fetchGEO(geo, 'GET');
            document.getElementById('rua').value=(endereco.logradouro);
            document.getElementById('bairro').value=(endereco.bairro);
            document.getElementById('cidade').value=(endereco.localidade);
            document.getElementById('estado').value=(endereco.uf);
            document.getElementById('latitude').value=(dados[0].lat);
            document.getElementById('longitude').value=(dados[0].lon);
        } catch (error) {
            console.error(error);
        }
    }
    async cadastrar(endereco) {
        try {
            
            const data = await this.buscaApi.fetchApi('Enderecos', 'POST', endereco);

            if (data.status) {
                this.displayMessage('Endereço registrado com sucesso!');
            } else {
                this.displayMessage('Erro ao registrar o Endereço.');
            }
        } catch (error) {
            console.error('Erro ao registrar:', error);
            this.displayMessage('Erro ao registrar o Endereço.');
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
            <form class="w3-container" id="enderecoForm">
                <div class="w3-section">
                <label for="cep">CEP</label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="cep" id="cep" placeholder="Insira o CEP" required />
                </div>
                <div class="w3-section">
                <label for="rua">Rua</label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="rua" id="rua" placeholder="Insira a Rua" required />
                </div>
                <div class="w3-section">
                    <label for="bairro">Bairro</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="bairro" id="bairro" placeholder="Insira o Bairro" required />
                </div>
                <div class="w3-section">
                    <label for="cidade">Cidade</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="cidade" id="cidade" placeholder="Insira a Cidade" required />
                </div>
                <div class="w3-section">
                    <label for="estado">Estado</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="estado" id="estado" placeholder="Insira o Estado" required />
                </div>
                <div class="w3-section">
                    <label for="latitude">Latitude</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="latitude" id="latitude" placeholder="Insira a Latitude" />
                </div>
                <div class="w3-section">
                    <label for="longitude">Longitude</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="longitude" id="longitude" placeholder="Insira a Longitude" />
                </div>
                <button type="submit" class="w3-button w3-block w3-green w3-section w3-padding">Cadastrar</button>
                <p id="message"></p>
            </form>
           
            </div>
            </div>
            </div>
        `;

        registrationContainer.querySelector('#cep').addEventListener('blur', async (event) => {
            event.preventDefault();
           this.buscaCep(event.target.value);
           
        });
        registrationContainer.querySelector('#enderecoForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            let endereco = {};
            const elements = registrationContainer.querySelector('#enderecoForm').elements;
        
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                if (element.name && element.value) {
                    endereco[element.name] = element.value;
                }
            }

            if (endereco.cep=='') {
                this.displayMessage("Cep invalido");
                return;
            }
            
            await this.cadastrar(endereco);
        });

        
         mainDiv.appendChild(registrationContainer);
        return {
            element: mainDiv,
            init: () => {}
        };
    }
}

const enderecos = new CadEnderecos();
const renderedElement = enderecos.render();
enderecos.init();
document.body.appendChild(renderedElement.element);