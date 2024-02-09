export default class MenuGenerator {
    constructor(navigateCallback, lang, telasPermitidas) {
        this.navigateCallback = navigateCallback;
        this.menuItems = [
            { href: "facil", icon: "assets/img/lotofacil.png", text: "LOTOFACIL", id: "1-0" },
            { href: "saloes", icon: "assets/img/megasena.png", text: "MEGASENA", id: "1-1" },
            { href: "index", icon: "assets/img/quina.png", text: "QUINA", id: "0-2" },
            { href: "usuarios", icon: "assets/img/users.png", text: "USERS", id: "0-0" },
            { href: "permissoes", icon: "assets/img/permiss.png", text: "PERFIL", id: "0-0" }
        ];
        this.telasPermitidas = telasPermitidas;
        this.userLanguage = lang; 
        this.loadLanguage();
        this.init();
    }
    loadLanguage() {
        this.userLanguage = this.userLanguage.split('-')[0];
        fetch(`assets/js/lang/${this.userLanguage}.json`)
            .then(response => response.json())
            .then(translations => {
                document.querySelectorAll("[data-i18n]").forEach(elem => {
                    const key = elem.getAttribute("data-i18n");
                    elem.textContent = translations[key];
                });
            });
    }
    init() {
        this.atualizaEstiloCabecalho();
    }

    atualizaEstiloCabecalho() {
        const cabecalho = document.querySelector('.app-header');
        if (cabecalho) {
            cabecalho.style.background = 'linear-gradient(rgb(0, 0, 0), rgb(68, 131, 88), rgb(94, 194, 127))'; 
            cabecalho.style.boxShadow = 'rgb(82 195 119) 0px 36px 36px 56px'; 
        }
    }
    updatePermitidas(novasTelasPermitidas) {
        this.telasPermitidas = novasTelasPermitidas;
        this.render(); 
    }
    render() {
        document.getElementById('titulo').innerHTML='Boa Sorte!';
        const menuContainer = document.createElement('div');
        menuContainer.className = 'main';
        menuContainer.classList.add = 'container';
        this.menuItems.forEach(item => {
            console.log(`Checando item: ${item.href}, permitido: ${this.telasPermitidas.includes(item.href)}`);
            if (this.telasPermitidas.includes(item.href)) {
                const link = document.createElement('a');
                link.href = '#';
                link.onclick = () => this.navigateCallback(item.href);

                const menuItem = document.createElement('div');
                menuItem.className = 'menu__item';
                menuItem.id = item.id;

                const icon = document.createElement('img');
                icon.className = 'menu__icon';
                icon.src = item.icon;

                const menuContent = document.createElement('div');
                menuContent.className = 'menu__content';
            for (let i = 0; i < 2; i++) {
                const span = document.createElement('span');
                span.className = 'menu__span';
                menuContent.appendChild(span);
            }

            menuItem.appendChild(icon);
            menuItem.appendChild(menuContent);
            link.appendChild(menuItem);

            const textSpan = document.createElement('span');
            textSpan.setAttribute('data-i18n', item.text);
            link.appendChild(textSpan);

            menuContainer.appendChild(link);
            }
        });
        

        const currentDiv = document.createElement('div');
        currentDiv.className = 'is-active';
        currentDiv.id = 'current';
        menuContainer.appendChild(currentDiv);
        return {
            element: menuContainer,
            init: () => {}
        };
    }
}
