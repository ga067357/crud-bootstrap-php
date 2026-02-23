<?php
// Inclui config primeiro para garantir que sessão e funções existam
require_once("../config.php"); // Contém is_logged(), protect() e sessão
require_once(DBAPI);           // Funções de banco de dados

$customers = null;
$customer  = null;

/* ============================
   LISTAR
============================ */
function index() {
    global $customers;
    $customers = find_all("customers");
}

/* ============================
   ADICIONAR
============================ */
function add() {
    protect(); // visitante não pode enviar POST

    if (!empty($_POST['customer'])) {
        $today = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
        $customer = $_POST['customer'];

        $customer['created']  = $today->format("Y-m-d H:i:s");
        $customer['modified'] = $customer['created'];

        if (!empty($_FILES['image']['name'])) {
            $customer['image'] = upload_image($_FILES['image']);
        }

        save("customers", $customer);

        $_SESSION['message'] = "Cliente cadastrado com sucesso!";
        $_SESSION['type'] = "success";

        header("Location: index.php");
        exit;
    }
}

/* ============================
   EDITAR
============================ */
function edit() {
    protect();

    $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (!empty($_POST['customer'])) {
            $customer = $_POST['customer'];
            $customer['modified'] = $now->format("Y-m-d H:i:s");

            if (!empty($_FILES['image']['name'])) {
                $newImage = upload_image($_FILES['image']);
                if ($newImage) {
                    $old = find("customers", $id);
                    $dir = "../uploads/customers/";
                    if (!empty($old['image']) && file_exists($dir . $old['image'])) {
                        unlink($dir . $old['image']);
                    }
                    $customer['image'] = $newImage;
                }
            }

            update("customers", $id, $customer);

            $_SESSION['message'] = "Cliente atualizado!";
            $_SESSION['type'] = "success";

            header("Location: index.php");
            exit;
        } else {
            global $customer;
            $customer = find("customers", $id);
        }
    } else {
        header("Location: index.php");
        exit;
    }
}

/* ============================
   VISUALIZAR
============================ */
function view($id = null) {
    global $customer;
    $customer = find("customers", $id);
}

/* ============================
   DELETAR
============================ */
function delete($id = null) {
    protect();

    global $customer;
    $customer = find("customers", $id);

    $dir = "../uploads/customers/";
    if (!empty($customer['image']) && file_exists($dir . $customer['image'])) {
        unlink($dir . $customer['image']);
    }

    remove("customers", $id);

    $_SESSION['message'] = "Cliente removido!";
    $_SESSION['type'] = "success";

    header("Location: index.php");
    exit;
}

/* ============================
   FORMATADORES
============================ */
function formataData($data, $formato) {
    if (empty($data)) return null;
    try {
        $d = new DateTime($data, new DateTimeZone("America/Sao_Paulo"));
        return $d->format($formato);
    } catch (Exception $e) {
        return $data;
    }
}

function formataTel($telefone) {
    return "(" . substr($telefone,0,2) . ")" .
           substr($telefone,2,5) . "-" . substr($telefone,7,4);
}

function cepFormat($cep) {
    return substr($cep,0,5) . "-" . substr($cep,5,3);
}

/* ============================
   UPLOAD DE IMAGEM
============================ */
function upload_image($file) {
    $dir = "../uploads/customers/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $fileName = time() . "_" . basename($file["name"]);
    $target = $dir . $fileName;

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

    if (!in_array($ext, $allowed)) return null;
    if ($file["size"] > 5 * 1024 * 1024) return null;

    if (move_uploaded_file($file["tmp_name"], $target)) {
        return $fileName;
    }

    return null;
}