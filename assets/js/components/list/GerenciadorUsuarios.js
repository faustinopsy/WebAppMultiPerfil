import BuscaApi from '../lib/BuscaApiG.js';

export default class GerenciadorUsuarios {
    constructor() {
        this.buscaApi = new BuscaApi(sessionStorage.getItem('token'));
        this.usuario_perfil=null;
        
    }

    async init() {
        await this.buscaUsers();
        await this.populatePerfis();
    }
    async getPerfis() {
        return await this.buscaApi.fetchApi('Usuarios/perfil', 'GET');
    }
    async inativeUsuario(email,chk) {
        return await this.buscaApi.fetchApi(`Usuarios`, 'PUT', { email,chk });
    }
    async perfilUsuario(email,perf) {
        return await this.buscaApi.fetchApi(`Usuarios/perfil`, 'PUT', { email,perf });
    }
    async deleteUsuario(email) {
        return await this.buscaApi.fetchApi(`Usuarios`, 'DELETE', { email });
    }

    async buscaUsers() {
        try {
            const data = await this.buscaApi.fetchApi(`Usuarios`, 'GET');
            this.renderUsers(data.Usuarios);
        } catch (error) {
            console.error(error);
            
        }
    }
    
    renderUsers(usuarios) {
        const divUser = document.querySelector('.main');

        usuarios.forEach(usuario => {
            this.usuario_perfil= usuario.perfilid;
            const container = document.createElement("div");
            container.classList.add("w3-card-4");
            container.innerHTML = `
                <div class="w3-container">
                    <h3>Dados no banco</h3>
                    <p>Id: ${usuario.id}</p>
                    <h3>Nome: ${usuario.nome}</h3>
                    <p id="emailcard" data-email="${usuario.email}">Email: ${usuario.email}</p>
                </div>
                <label for="perfilSelect">Perfil Atual: ${usuario.perfil}</label>
                <select class="perfilSelect w3-select" required>
                    <option value="">Selecione</option>
                </select>
            `;
            const switchLabel = document.createElement('label');
            switchLabel.classList.add('switch');
            const ativeBtn = document.createElement('input');
            ativeBtn.id = "myCheck";
            ativeBtn.type = "checkbox";
            if(usuario.ativo===2){
                ativeBtn.checked = true
            }
            ativeBtn.addEventListener('click', async () => {
                if (ativeBtn.checked) {
                    const result = await this.inativeUsuario(usuario.email,2);
                    Swal.fire("Sucesso!", "Usuário bloqueado com sucesso!", "sucess");
                } else {
                    const result = await this.inativeUsuario(usuario.email,1);
                    Swal.fire("Sucesso!", "Usuário Ativado.", "sucess");
                }
            });
            const hr = document.createElement('hr');
            const span = document.createElement('span');
            span.innerText = "Bloquear Usuário"
            const sliderSpan = document.createElement('span');
            sliderSpan.classList.add('slider', 'round');
            switchLabel.appendChild(ativeBtn);
            switchLabel.appendChild(sliderSpan);
            container.appendChild(hr);
            container.appendChild(span);
            container.appendChild(switchLabel);

            const removeBtn = document.createElement('button');
            removeBtn.textContent = "Remover Usuário";
            removeBtn.classList.add("w3-button","w3-red", "w3-border", "w3-hover-black", "w3-block");
            removeBtn.addEventListener('click', async () => {
                const result = await this.deleteUsuario(usuario.email);
                if (result.status) {
                    Swal.fire("Sucesso!", "Usuário removido com sucesso!", "sucess");
                    container.remove();
                } else {
                    Swal.fire("Alerta!", result.message, "info");
                }
            });
            container.appendChild(removeBtn);
            
            divUser.appendChild(container);
        });

        
    }
    
    async populatePerfis() {
        const perfis = await this.getPerfis();
        const select = document.querySelectorAll('.perfilSelect');
        select.forEach(select => {
            while (select.options.length > 1) {
                select.remove(1);
            }
        perfis.perfis.forEach(perfil => {
                const option = document.createElement('option');
                option.value = perfil.nome;
                option.textContent = perfil.nome;
                select.appendChild(option);
        });
        select.addEventListener('change', async (event) => {
            let email = document.getElementById("emailcard");
            const result = await this.perfilUsuario(email.dataset.email,event.target.value);
            if (result.status) {
                Swal.fire("Sucesso!", `${result.status.message}`, "sucess");
                location.reload();
            }
        });
    });
        
    }
    render() {
        document.getElementById('titulo').innerHTML='Gerir Usuários';
        const mainDiv = document.createElement('div');
        mainDiv.className = 'main';
        return {
            element: mainDiv,
            init: () => this.init()
        };
    }
}

