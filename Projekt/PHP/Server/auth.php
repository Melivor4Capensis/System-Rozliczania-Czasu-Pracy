<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin(): void
{
    if (!isset($_SESSION['id'])) {
        header("Location: /Projekt/index.php");
        exit;
    }
}

function requireRole(string $role): void
{
    requireLogin();

    if ($_SESSION['role'] !== $role) {

        switch ($_SESSION['role']) {

            case 'admin':
                header("Location: /Projekt/PHP/UI/panelAdmina.php");
                break;

            case 'kadrowa':
                header("Location: /Projekt/PHP/UI/kalendarzPracy.php");
                break;

            case 'pracownik':
                header("Location: /Projekt/PHP/UI/raportCzasuPracy.php");
                break;
                
            default:
                header("Location: /Projekt/index.php");
                break;
        }

        exit;
    }
}