<?php
session_start();
include_once "../Server/dbConnect.php";

if (!isset($_SESSION['id'])) {
    header("Location: /Projekt/index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'], $_POST['password2'])) {
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($password === '') {
        $error = "Podaj nowe hasło";
    } elseif (strlen($password) < 6) {
        $error = "Hasło musi mieć minimum 6 znaków";
    } elseif ($password !== $password2) {
        $error = "Hasła nie są identyczne";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $update = $db->prepare("UPDATE users SET password = ?, must_change_password = 0 WHERE id = ?");
        $update->bind_param("si", $hashed, $_SESSION['id']);

        if ($update->execute()) {
            $update->close();

            $stmt = $db->prepare("SELECT role FROM users WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['id']);
            $stmt->execute();
            $role = $stmt->get_result()->fetch_assoc()['role'];
            $stmt->close();

            $routes = [
                'admin'     => "/Projekt/PHP/UI/panelAdmina.php",
                'pracownik' => "/Projekt/PHP/UI/raportCzasuPracy.php",
                'kadrowa'   => "/Projekt/PHP/UI/kalendarzPracy.php",
            ];

            header("Location: " . $routes[$role]);
            exit;
        } else {
            $error = "Błąd zapisu";
            $update->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Rozliczania Czasu Pracy</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-container">
            <h1 id="auth-title">NOWE HASŁO</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="auth-form">
                <label class="input-image-wrap">
                    <img class="input-icon" src="../../Assets/Lock-Icon.svg" alt="lock-icon">
                    <input type="password" name="password" class="auth-input" placeholder="Nowe hasło">
                </label>
                <label class="input-image-wrap">
                    <img class="input-icon" src="../../Assets/Lock-Icon.svg" alt="lock-icon">
                    <input type="password" name="password2" class="auth-input" placeholder="Powtórz hasło">
                </label>
                <p class="errorMessage"><?= htmlspecialchars($error) ?></p>
                <button type="submit" class="auth-button">Zapisz hasło</button>
            </form>
            <div class="auth-avatar">
                <img src="../../Assets/Torso-Icon.svg" alt="torso-icon">
            </div>
        </div>
    </div>
</body>

</html>
