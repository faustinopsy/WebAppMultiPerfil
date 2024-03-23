export default class Navbar {
    constructor(navigateCallback, telasPermitidas) {
        this.navigateCallback = navigateCallback;
        this.menuItems = [
            { text: 'admin', icon: "assets/img/admin.png"},
            { text: 'sobre', icon: "assets/img/about.png" },
            { text: 'gerirsaloes', icon: "assets/img/salon.png"},
            { text: 'mapa', icon: "assets/img/home.png"},
            { text: 'minhaarea', icon: "assets/img/users.png"},
            { text: 'login', icon: "assets/img/login.png" },
            { text: 'usuarios', icon: "assets/img/users.png" },
        ];
        this.menuItemsPublicos = [
            { text: 'sobre', icon: "assets/img/about.png" },
            { text: 'mapa', icon: "assets/img/home.png"},
            { text: 'login', icon: "assets/img/login.png" },
        ];
        this.telasPermitidas = telasPermitidas;
    }
    init() {
        const navbarElement = document.getElementById('navbar');
        if (!navbarElement) return; 
    
        let lastScrollTop = 0;
    
        window.addEventListener("scroll", function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            if (currentScroll > lastScrollTop) {
                navbarElement.style.bottom = "-80px"; 
            } else {
                navbarElement.style.bottom = "0"; 
            }
            lastScrollTop = currentScroll;
        }, false);
    }
    updatePermitidas(novasTelasPermitidas) {
        this.telasPermitidas = novasTelasPermitidas;
        this.renderRestrito(); 
    }
    renderRestrito() {
        const navbarElement = document.createElement('header');
        navbarElement.id = 'navbar';
        
        this.menuItems.forEach(item => {
            //console.log(`Checando item: ${item.text}, permitido: ${this.telasPermitidas.includes(item.text)}`);
            if (this.telasPermitidas.includes(item.text)) {
                const linkElement = document.createElement('a');
                linkElement.href = '#';
                linkElement.className = 'btn';
                const icon = document.createElement('img');
                icon.className = 'icon';
                icon.src = item.icon;

                linkElement.dataset.link = item.text;
                linkElement.addEventListener('click', (event) => this.onNavigate(event, item.text));
                linkElement.appendChild(icon);
                navbarElement.appendChild(linkElement);
            }
            
        });

        return navbarElement;
    }
    render() {
        const navbarElement = document.createElement('header');
        navbarElement.id = 'navbar';
        
        this.menuItemsPublicos.forEach(item => {
                const linkElement = document.createElement('a');
                linkElement.href = '#';
                linkElement.className = 'btn';
                const icon = document.createElement('img');
                icon.className = 'icon';
                icon.src = item.icon;

                linkElement.dataset.link = item.text;
                linkElement.addEventListener('click', (event) => this.onNavigate(event, item.text));
                linkElement.appendChild(icon);
                navbarElement.appendChild(linkElement);
            
            
        });

        return navbarElement;
    }
    onNavigate(event, link) {
        event.preventDefault();
        this.navigateCallback(link);
    }

    toggleHamburgerMenu() {
        const navbarElement = document.querySelector('.navbar');
        navbarElement.classList.toggle('responsive');
    }
    update() {
        const navbarElement = this.renderRestrito();
        document.body.replaceChild(navbarElement, document.querySelector('header'));
    }
    
}
