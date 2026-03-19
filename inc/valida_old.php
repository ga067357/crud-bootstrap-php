<?php
// inc/valida.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config.php");
require_once(DBAPI);

/* =======================================================
   FUNÇÕES DE CONTROLE DE ACESSO
======================================================= */

function isLogged() {
    return isset($_SESSION['id']);
}

function isAdmin() {
    return (isset($_SESSION['nivel']) && strtolower($_SESSION['nivel']) === 'admin');
}


function requireLogin() {
    if (!isLogged()) {
        $_SESSION['message'] = "Você precisa estar logado.";
        $_SESSION['type'] = "danger";
        header("Location: " . BASEURL . "inc/login.php");
        exit;
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        $_SESSION['message'] = "Acesso permitido somente para administradores.";
        $_SESSION['type'] = "danger";
        header("Location: " . BASEURL . "index.php");
        exit;
    }
}

/* =======================================================
   PROCESSO DE LOGIN (APENAS LOGIN.PHP DEVE ACIONAR)
======================================================= */

if (isset($_POST['login']) && isset($_POST['senha'])) {

    if (empty($_POST['login']) || empty($_POST['senha'])) {
        $_SESSION['message'] = "Preencha usuário e senha.";
        $_SESSION['type'] = "danger";
        header("Location: " . BASEURL . "inc/login.php");
        exit;
    }

    try {
        $usuario = $_POST['login'];
        $senha = md5($_POST['senha']);

        $sql = "SELECT id, nome, user, password, nivel 
                FROM usuarios
                WHERE user = '{$usuario}'
                  AND password = '{$senha}'
                LIMIT 1";

        $bd = open_database();
        $query = $bd->query($sql);

        if ($query->num_rows === 1) {

            $dados = $query->fetch_assoc();

            $_SESSION['id']    = $dados['id'];
            $_SESSION['nome']  = $dados['nome'];
            $_SESSION['user']  = $dados['user'];
            $_SESSION['nivel'] = $dados['nivel'];

            $_SESSION['message'] = "Bem vindo, {$dados['nome']}!";
            $_SESSION['type'] = "success";

            header("Location: " . BASEURL . "index.php");
            exit;

        } else {
            throw new Exception("Usuário ou senha inválidos.");
        }

    } catch (Exception $e) {

        $_SESSION['message'] = "Erro: " . $e->getMessage();
        $_SESSION['type'] = "danger";

        header("Location: " . BASEURL . "inc/login.php");
        exit;
    }
}
?>
