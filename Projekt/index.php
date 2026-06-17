<?php
session_start();
include_once "PHP/Server/dbConnect.php";

$error = '';
$loginValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'], $_POST['password'])) {
    $loginValue = htmlspecialchars(trim($_POST['login']));
    $password = $_POST['password'];

    if ($loginValue === '') {
        $error = "Podaj login";
    } elseif ($password === '') {
        $error = "Podaj hasło";
    } else {
        $stmt = $db->prepare("SELECT id, password, role, must_change_password FROM users WHERE login = ?");
        $stmt->bind_param("s", $loginValue);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$user || $user['password'] === null) {
            $error = "Błędny login";
        } elseif (!password_verify($password, $user['password'])) {
            $error = "Niepoprawne hasło";
        } else {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ((int)$user['must_change_password'] === 1) {
                header("Location: /Projekt/PHP/UI/zmianaHasla.php");
                exit;
            }

            redirectByRole($user['role']);
        }
    }
}

function redirectByRole(string $role): void
{
    $routes = [
        'admin'     => "/Projekt/PHP/UI/panelAdmina.php",
        'pracownik' => "/Projekt/PHP/UI/raportCzasuPracy.php",
        'kadrowa'   => "/Projekt/PHP/UI/kalendarzPracy.php",
    ];

    if (!isset($routes[$role])) {
        die("Błąd roli");
    }

    header("Location: " . $routes[$role]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Rozliczania Czasu Pracy</title>
    <link rel="stylesheet" href="style.css">
    <script src="JS/authorizationValidation.js" defer></script>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <h1 id="auth-title">LOGIN</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="auth-form" id="authForm">
                <label class="input-image-wrap">
                    <img class="input-icon" src="Assets/User-Icon.svg" alt="user-icon">
                    <input type="text" name="login" class="auth-input" id="loginInput" placeholder="Login" value="<?= htmlspecialchars($loginValue) ?>">
                </label>
                <label class="input-image-wrap">
                    <img class="input-icon" src="Assets/Lock-Icon.svg" alt="lock-icon">
                    <input type="password" name="password" class="auth-input" id="passwordInput" placeholder="Hasło">
                </label>
                <p class="errorMessage"><?= htmlspecialchars($error) ?></p>
                <button type="submit" class="auth-button">Zaloguj</button>
            </form>
            <div class="auth-avatar">
                <img src="Assets/Torso-Icon.svg" alt="torso-icon">
            </div>
        </div>
    </div>
</body>

</html>