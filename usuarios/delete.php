<?php
// usuarios/delete.php

if (session_status() === PHP_SESSION_NONE) session_start();

require_once("../config.php");
require_once("functions.php");

// 🔒 Somente administradores podem excluir
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] !== 'admin') {
    $_SESSION['message'] = "Apenas administradores podem excluir usuários.";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "usuarios/index.php");
exit;

}

try {

    if (empty($_GET['id'])) {
        $_SESSION['message'] = "ID do usuário não informado.";
        $_SESSION['type'] = "danger";
        header("Location: index.php");
        exit;
    }

    $id = intval($_GET['id']);

    // Impede excluir a si mesmo
    if ($id == $_SESSION['id']) {
        $_SESSION['message'] = "Você não pode excluir seu próprio usuário.";
        $_SESSION['type'] = "warning";
        header("Location: index.php");
        exit;
    }

    $usuario = find('usuarios', $id);

    if (!$usuario) {
        $_SESSION['message'] = "Usuário não encontrado.";
        $_SESSION['type'] = "warning";
        header("Location: index.php");
        exit;
    }

    // A função delete() do functions já remove imagem e registro
    delete($id);
    exit;

} catch (Exception $e) {
    $_SESSION['message'] = "Erro ao excluir usuário: " . $e->getMessage();
    $_SESSION['type'] = "danger";
    header("Location: index.php");
    exit;
}
