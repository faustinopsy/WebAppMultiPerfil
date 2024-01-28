import ValidadorToken from './components/lib/ValidadorToken.js';
import GerenciadorUsuarios from './components/list/GerenciadorUsuarios.js';
import LoginScreen from './components/screen/LoginScreen.js';
import GerenciadorPermissoes from './components/list/GerenciadorPermissoes.js';
import RegistrationScreen from './components/screen/RegistrationScreen.js';
import RecoveryScreen from './components/screen/RecoveryScreen.js';
import ListaProdutos from './components/list/ListaProdutos.js';
import Admin from './components/screen/Admin.js';
import About from './components/screen/About.js';
import GerenciadorProdutos from './components/list/GerenciadorProdutos.js';
import HeatmapComponent from './components/lib/HeatmapComponent.js';

class App {
    constructor() {
        this.userLanguage = navigator.language || navigator.userLanguage;
        this.appElement = document.getElementById('app');
        this.tokenJWT = new ValidadorToken(this.navigate.bind(this),this.userLanguage);
        this.tokenJWT.init();
    }

navigate(link) {
    if (this.appElement) {
        this.appElement.innerHTML = '';
    } else {
        console.error('Elemento #app não encontrado');
    }
    

    let componentInstance =  this.getComponentInstance(link);
    

    if (componentInstance) {
        const { element, init } = componentInstance.render();
        this.appElement.appendChild(element);
        if (init && typeof init === 'function') {
            init();
        }
    }
}

addPopStateListener() {
    window.addEventListener('popstate', (event) => {
        const path = window.location.pathname.replace('/', '');
        history.pushState(null, '', path);
    });
}


getComponentInstance(link) {
  
            switch (link) {
                case 'usuarios':
                    return new GerenciadorUsuarios();
                   
                case 'recuperarSenha':
                    return new RecoveryScreen(this.navigate.bind(this));
                   
                case 'cadastro':
                    return new RegistrationScreen(this.navigate.bind(this));
                   
                case 'admin':
                    return new Admin(this.navigate.bind(this), this.userLanguage);
                    
                case 'permissoes':
                    return new GerenciadorPermissoes();
                   
                case 'sobre':
                    return new About(this.userLanguage);
                   
                case 'produtos':
                    return new ListaProdutos();

                case 'gerirprodutos':
                    return new GerenciadorProdutos();
                   
                case 'login':
                    return new LoginScreen(this.navigate.bind(this));
                
                case 'experiencia':
                    return new HeatmapComponent();
                    
                default:
                    return null;
                    
            }
       
}

}

document.addEventListener('DOMContentLoaded', function() {
    new App();
});
