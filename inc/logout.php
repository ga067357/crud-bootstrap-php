<?php
// logout.php -- dentro de /inc/

if (!isset($_SESSION)) session_start();

session_unset();   // limpa variáveis
session_destroy(); // destrói a sessão

// redireciona para a página inicial
header("Location: ../index.php");
exit;
