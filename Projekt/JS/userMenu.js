const menu = document.getElementById('userMenu');
const trigger = document.getElementById('userMenuTrigger');

if (menu && trigger) {
    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.toggle('open');
    });

    document.addEventListener('click', () => menu.classList.remove('open'));
}