<?php 
require_once "../config.php";
require_once "../inc/valida.php"; // contém requireLogin()
require_once "functions.php";

// 🔒 Exclusão só pode ser feita por usuários logados
requireLogin();

try {
    if (!isset($_GET['id'])) {
        $_SESSION['message'] = "ID do avião não informado.";
        $_SESSION['type'] = "danger";
        header("Location: index.php");
        exit();
    }

    $id = $_GET['id'];
    $airplane = find('airplanes', $id);

    if (!$airplane) {
        $_SESSION['message'] = "Avião não encontrado.";
        $_SESSION['type'] = "warning";
        header("Location: index.php");
        exit();
    }

    // ✔ Agora, quem apaga imagem + registro é a FUNÇÃO delete()
    delete($id);

    $_SESSION['message'] = "Avião excluído com sucesso.";
    $_SESSION['type'] = "success";

    header("Location: index.php");
    exit();

} catch (Exception $e) {
    $_SESSION['message'] = "Erro ao excluir avião: " . $e->getMessage();
    $_SESSION['type'] = "danger";
    header("Location: index.php");
    exit();
}
?>
