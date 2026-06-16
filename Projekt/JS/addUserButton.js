const tbody = document.getElementById("userMenagementTbody")

document.getElementById("addUserButton").addEventListener('click', e => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
        <td><input type="text" name="user[new][surname]"></td>
        <td><input type="text" name="user[new][name]"></td>
        <td><input type="text" name="user[new][login]"></td>
        <td>
            <select class="user-role-select" name="user[new][role]">
                <option value="pracownik">Pracownik</option>
                <option value="kadrowa">Kadrowa</option>
                <option value="admin">Admin</option>
            </select>
        </td>
        <td>
            <button class="delete-user-button">Usuń</button>
            <button class="reset-password-button">Resetuj Hasło</button>
        </td>
    `;
    tbody.prepend(tr);
})