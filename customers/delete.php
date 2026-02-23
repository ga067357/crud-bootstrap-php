<?php
require_once "../config.php";
require_once "functions.php";
require_once "../inc/valida.php";

requireLogin();

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $customer = find('customers', $id);

        if ($customer) {
            if (!empty($customer['image'])) {
                $filePath = "../uploads/customers/" . $customer['image'];
                if (file_exists($filePath)) {
                    unlink($filePath); 
                }
            }

            delete($id);

            $_SESSION['message'] = "Cliente excluído com sucesso.";
            $_SESSION['type'] = "success";
        } else {
            $_SESSION['message'] = "Cliente não encontrado.";
            $_SESSION['type'] = "warning";
        }

        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = "ID do cliente não informado.";
        $_SESSION['type'] = "danger";
        header("Location: index.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['message'] = "Erro ao excluir cliente: " . $e->getMessage();
    $_SESSION['type'] = "danger";
    header("Location: index.php");
    exit();
}
?>