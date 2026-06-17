const menu = document.getElementById('userMenu');
document.getElementById('userMenuTrigger').addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('open');
});
document.addEventListener('click', () => menu.classList.remove('open'));

const roleLabels = {
    admin: 'Admin',
    pracownik: 'Pracownik',
    kadrowa: 'Kadrowa',
};

(async function loadCurrentUser() {
    try {
        const response = await fetch('/Projekt/PHP/Server/getCurrentUser.php');
        const result = await response.json();

        if (!result.success) return;

        const fullName = `${result.user.name} ${result.user.surname}`;
        const roleLabel = roleLabels[result.user.role] || result.user.role;

        document.querySelector('#userMenuTrigger p').textContent = `Zalogowano jako: ${fullName}`;
        document.querySelector('.user-menu-name').textContent = fullName;
        document.querySelector('.user-menu-role').textContent = roleLabel;
    } catch (error) {
        console.error("Błąd wczytywania danych użytkownika:", error);
    }
})();

document.querySelector('.user-menu-item.danger').addEventListener('click', () => {
    window.location.href = '/Projekt/PHP/Server/logout.php';
});
