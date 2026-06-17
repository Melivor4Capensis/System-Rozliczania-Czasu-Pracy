const loginInput = document.getElementById("loginInput");
const passwordInput = document.getElementById("passwordInput");
const form = document.getElementById("authForm");

form.addEventListener('submit', e => {
    e.preventDefault();
    loginInput.closest("label").classList.remove("error");
    passwordInput.closest("label").classList.remove("error");

    let valid = true;

    if (loginInput.value.length > 50 || loginInput.value.length == 0) {
        valid = false;
        loginInput.closest("label").classList.add("error");
    }else if (passwordInput.value.length > 50 || passwordInput.value.length == 0) {
        valid = false;
        passwordInput.closest("label").classList.add("error");
    }

    if (valid) {
        form.submit();
    }
})

