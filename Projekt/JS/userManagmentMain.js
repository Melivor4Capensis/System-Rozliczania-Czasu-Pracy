import { loadUsers, resetUsers } from './AJAX/userMenagementTableFetchUsers.js';

await loadUsers(20);

const tableContainer = document.getElementById("primaryMain"); 

tableContainer.addEventListener('scroll', () => {
    const { scrollTop, scrollHeight, clientHeight } = tableContainer;
    const isAtBottom = scrollTop + clientHeight >= scrollHeight - 50; 

    if (isAtBottom) {
        loadUsers(20);
    }
});

window.addEventListener('reloadTable', async () => {
    resetUsers();
    await loadUsers(20);
});