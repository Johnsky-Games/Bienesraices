document.addEventListener('DOMContentLoaded', function () {
    eventListeners();
    darkMode();
});

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
    if (navegacion.classList.contains('mostrar')) {
        navegacion.classList.remove('mostrar');
    } else {
        navegacion.classList.add('mostrar');
    };
};

function darkMode() {
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    const botonDarkMode = document.querySelector('.dark-mode-boton');
    let isDarkMode = localStorage.getItem('darkMode') === 'true';

    function setDarkMode() {
        isDarkMode = !isDarkMode;
        document.body.classList.toggle('dark-mode', isDarkMode);
        localStorage.setItem('darkMode', isDarkMode);
    }

    botonDarkMode.removeEventListener('click', setDarkMode); // Remove previous event listener
    botonDarkMode.addEventListener('click', setDarkMode);

    if (prefersDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    if (isDarkMode) {
        document.body.classList.add('dark-mode');
    }
}




