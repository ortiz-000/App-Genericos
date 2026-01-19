import './bootstrap';  // siempre primero
import './Clientes';
import './empleados';
import './users';
import './home';
import './Mensajeria';




// Código global del menú
document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.querySelector('.sidebar');

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }
});





