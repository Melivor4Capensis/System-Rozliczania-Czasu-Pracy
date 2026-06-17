const addUserButton = document.getElementById("addUserButton");
const modal = document.getElementById("addUserModal");
const closeButton = document.getElementById("addUserModalClose");
const cancelButton = document.getElementById("addUserModalCancel");
const form = document.getElementById("addUserForm");

function openModal() {
    modal.classList.add('visible');
    clearFieldErrors();
    form.reset();
}

function closeModal() {
    modal.classList.remove('visible');
}

function clearFieldErrors() {
    form.querySelectorAll('.field-error').forEach(el => el.classList.remove('field-error'));
}

addUserButton.addEventListener('click', openModal);
closeButton.addEventListener('click', closeModal);
cancelButton.addEventListener('click', closeModal);

modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    clearFieldErrors();

    const newUser = {
        surname: form.querySelector('[name="newUser[surname]"]').value.trim(),
        name: form.querySelector('[name="newUser[name]"]').value.trim(),
        login: form.querySelector('[name="newUser[login]"]').value.trim(),
        role: form.querySelector('[name="newUser[role]"]').value,
        password: form.querySelector('[name="newUser[password]"]').value,
    };

    try {
        const response = await fetch('/Projekt/PHP/Server/createUser.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(newUser)
        });

        const result = await response.json();

        if (result.success) {
            closeModal();
            window.dispatchEvent(new CustomEvent('reloadTable'));
        } else {
            if (Array.isArray(result.fieldErrors)) {
                result.fieldErrors.forEach(fieldName => {
                    const field = form.querySelector(`[name="${fieldName}"]`);
                    if (field) field.classList.add('field-error');
                });
            }
            document.getElementById("addUserModalError").textContent = result.error || "Nie udało się dodać użytkownika";
        }
    } catch (error) {
        console.error("Błąd dodawania użytkownika:", error);
        document.getElementById("addUserModalError").textContent = "Błąd połączenia z serwerem";
    }
});
