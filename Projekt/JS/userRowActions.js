export function bindRowActions(row, userId) {
    const deleteButton = row.querySelector('.delete-user-button');
    
    const resetButton = row.querySelector('.reset-password-button');
    
    deleteButton.addEventListener('click', async () => {
        
        const confirmed = confirm("Czy na pewno chcesz usunąć tego użytkownika? Tej operacji nie można odwrócić.");
        if (!confirmed) return;

        try {
            const response = await fetch('/Projekt/PHP/Server/deleteUser.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userId })
            });

            const result = await response.json();

            if (result.success) {
                row.remove();
                showActionPopup('success', "Użytkownik został usunięty");
            } else {
                showActionPopup('error', result.error || "Nie udało się usunąć użytkownika");
            }
        } catch (error) {
            console.error("Błąd usuwania:", error);
            showActionPopup('error', "Błąd połączenia z serwerem");
        }
    });
    

    resetButton.addEventListener('click', async () => {
        const newPassword = prompt("Podaj nowe hasło dla użytkownika (minimum 6 znaków):");
        if (newPassword === null) return;

        if (newPassword.length < 6) {
            showActionPopup('error', "Hasło musi mieć minimum 6 znaków");
            return;
        }

        try {
            const response = await fetch('/Projekt/PHP/Server/resetPassword.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: userId, password: newPassword })
            });

            const result = await response.json();

            if (result.success) {
                showActionPopup('success', "Hasło zostało zresetowane. Użytkownik ustawi nowe przy logowaniu");
            } else {
                showActionPopup('error', result.error || "Nie udało się zresetować hasła");
            }
        } catch (error) {
            console.error("Błąd resetu hasła:", error);
            showActionPopup('error', "Błąd połączenia z serwerem");
        }
    });
}

function showActionPopup(type, message) {
    const popup = document.createElement('div');
    popup.className = `save-result-popup ${type}`;
    popup.innerHTML = `<p class="save-result-title">${message}</p>`;

    document.body.appendChild(popup);
    requestAnimationFrame(() => popup.classList.add('visible'));

    setTimeout(() => {
        popup.classList.remove('visible');
        setTimeout(() => popup.remove(), 250);
    }, 3500);
}
