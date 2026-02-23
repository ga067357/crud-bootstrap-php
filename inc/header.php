<?php
// Inicia sessão ANTES de qualquer HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>CRUD com Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/awesome/all.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark fixed-top" data-bs-theme="dark">
    <div class="container">

        <a class="navbar-brand" href="<?php echo BASEURL; ?>">
            <i class="fa-solid fa-house-chimney"></i> CRUD
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- CLIENTES -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-users"></i> Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo BASEURL; ?>customers/">Gerenciar Clientes</a></li>

                        <?php if (is_logged()) : ?>
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>customers/add.php">Novo Cliente</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <!-- AVIÕES -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-plane"></i> Aviões
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo BASEURL; ?>avioes/">Gerenciar Aviões</a></li>

                        <?php if (is_logged()) : ?>
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>avioes/add.php">Novo Avião</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <!-- USUÁRIOS — SOMENTE ADMIN -->
                <?php if (is_admin()) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-user-shield"></i> Usuários
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios/">Gerenciar Usuários</a></li>
                            <li><a class="dropdown-item" href="<?php echo BASEURL; ?>usuarios/add.php">Novo Usuário</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>

            <!-- Login / Logout -->
            <ul class="navbar-nav ms-auto">
                <?php if (is_logged()) : ?>
                    <li class="nav-item">
                        <span class="navbar-text text-white me-3">
                            <i class="fa fa-user"></i> <?php echo $_SESSION['nome']; ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASEURL; ?>inc/logout.php" class="btn btn-danger btn-sm">
                            <i class="fa fa-sign-out-alt"></i> Sair
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="<?php echo BASEURL; ?>inc/login.php" class="btn btn-success btn-sm">
                            <i class="fa fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>

    </div>
</nav>

<main class="container mt-5 pt-4">