<?php

/* ===========================
   CONFIGURAÇÕES DO BANCO
=========================== */

if (!defined("DB_NAME"))     define("DB_NAME", "wda_crud");
if (!defined("DB_USER"))     define("DB_USER", "root");
if (!defined("DB_PASSWORD")) define("DB_PASSWORD", "");
if (!defined("DB_HOST"))     define("DB_HOST", "localhost");

/* ===========================
   CAMINHOS DO SISTEMA
=========================== */

if (!defined("ABSPATH"))
    define("ABSPATH", dirname(__FILE__) . "/");

if (!defined("BASEURL"))
    define("BASEURL", "/crud-bootstrap-php/");   // ✔ Seu projeto REAL usa este caminho

if (!defined("DBAPI"))
    define("DBAPI", ABSPATH . "inc/database.php");

if (!defined("HEADER_TEMPLATE"))
    define("HEADER_TEMPLATE", ABSPATH . "inc/header.php");

if (!defined("FOOTER_TEMPLATE"))
    define("FOOTER_TEMPLATE", ABSPATH . "inc/footer.php");

/* ===========================
   INICIA SESSÃO
=========================== */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ===========================
   VERIFICAÇÃO DE LOGIN
=========================== */

function is_logged() {
    return isset($_SESSION['id']) && !empty($_SESSION['id']);
}

/* 
    CORREÇÃO CRUCIAL:
    no banco você salva 'admin' / 'user'
*/
function is_admin() {
    return isset($_SESSION['nivel']) && $_SESSION['nivel'] === 'admin';
}

function protect() {
    if (!is_logged()) {
        $_SESSION['message'] = "Você precisa estar logado para acessar esta página.";
        $_SESSION['type'] = 'danger';
        header('location: ' . BASEURL . 'inc/login.php');   // ✔ login.php no LUGAR CERTO
        exit;
    }
}

function admin_only() {
    protect();
    if (!is_admin()) {
        $_SESSION['message'] = "Acesso restrito a administradores.";
        $_SESSION['type'] = 'danger';
        header('location: ' . BASEURL . 'index.php'); // ✔ caminho correto
        exit;
    }
}

function clear_messages() {
    unset($_SESSION['message']);
    unset($_SESSION['type']);
}

