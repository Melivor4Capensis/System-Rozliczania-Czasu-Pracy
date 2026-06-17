import { bindRowActions } from '../userRowActions.js';

let loadedUsers = 0;
let isLoading = false;

export async function loadUsers(usersToLoad) {
    if (isLoading) return;
    isLoading = true;

    const tbody = document.getElementById("userMenagementTbody");

    try {
        const response = await fetch(`/Projekt/PHP/Server/getUsers.php?toLoad=${encodeURIComponent(usersToLoad)}&loaded=${encodeURIComponent(loadedUsers)}`)

        if (!response.ok) {
            throw new Error(`Błąd serwera: ${response.status}`);
        }

        const users = await response.json();

        if (users.length === 0) {
            if (!document.getElementById("lastRow") && loadedUsers === 0) {
                tbody.innerHTML += `<tr id="lastRow"><td colspan="5">Brak wyników</td></tr>`;
            }
            return;
        }

        loadedUsers += usersToLoad;

        users.forEach(user => {
            const tr = document.createElement("tr");
            tr.dataset.userId = user.id;
            tr.innerHTML = `
                <td><input type="text" name="user[${user.id}][surname]" value="${user.surname}"></td>
                <td><input type="text" name="user[${user.id}][name]" value="${user.name}"></td>
                <td><input type="text" name="user[${user.id}][login]" value="${user.login}"></td>
                <td>
                    <select class="user-role-select" name="user[${user.id}][role]">
                        <option value="pracownik"   ${user.role === "pracownik" ? "selected" : ""}>Pracownik</option>
                        <option value="kadrowa"     ${user.role === "kadrowa" ? "selected" : ""}>Kadrowa</option>
                        <option value="admin"       ${user.role === "admin" ? "selected" : ""}>Admin</option>
                    </select>
                </td>
                <td>
                    <button class="delete-user-button">Usuń</button>
                    <button class="reset-password-button">Resetuj Hasło</button>
                </td>
            `;
            tbody.appendChild(tr);

            bindRowActions(tr, user.id);
        });

        if (users.length < usersToLoad) {
            if (!document.getElementById("lastRow")) {
                const tr = document.createElement('tr');
                tr.id = 'lastRow';
                tr.innerHTML = '<td colspan="5">Koniec wyników</td>';

                tbody.appendChild(tr);;
            }
        }
    } catch (error) {
        console.error(error);
        tbody.innerHTML += `<tr><td colspan="5">Wystąpił błąd</td></tr>`;
    } finally {
        isLoading = false;
    }
}

export function resetUsers() {
    loadedUsers = 0;
    isLoading = false;
    document.getElementById("userMenagementTbody").innerHTML = '';
}
