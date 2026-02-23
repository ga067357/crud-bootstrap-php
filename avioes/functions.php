<?php

require_once "../config.php";
require_once DBAPI;

$airplanes = null;
$airplane = null;

function index() {
    global $airplanes;
    $airplanes = find_all("airplanes");
}

function add() {
    if (!empty($_POST['airplane'])) {
        $today = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
        $airplane = $_POST['airplane'];
        $airplane['modified'] = $airplane['created'] = $today->format("Y-m-d H:i:s");

        if (!empty($_FILES['image']['name'])) {
            $airplane['image'] = upload_image($_FILES['image']);
        }

        save("airplanes", $airplane);
        header("location: index.php");
        exit;
    }
}

function edit() {
    $now = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (isset($_POST['airplane'])) {
            $airplane = $_POST['airplane'];
            $airplane['modified'] = $now->format("Y-m-d H:i:s");

            if (!empty($_FILES['image']['name'])) {

                $newImage = upload_image($_FILES['image']);

                if ($newImage) {
                    // remove imagem antiga
                    $old = find("airplanes", $id);
                    $targetDir = "../assets/avioes/";

                    if (!empty($old['image']) && is_file($targetDir . $old['image'])) {
                        unlink($targetDir . $old['image']);
                    }

                    $airplane['image'] = $newImage;
                }
            }

            update("airplanes", $id, $airplane);
            header("location: index.php");
            exit;
        } else {
            global $airplane;
            $airplane = find("airplanes", $id);
        }
    }
}

function view($id = null) {
    global $airplane;
    $airplane = find("airplanes", $id);
}

function delete($id = null) {

    $airplane = find("airplanes", $id);
    $targetDir = "../assets/avioes/";

    // apaga imagem
    if (!empty($airplane['image'])) {
        $file = $targetDir . $airplane['image'];

        if (is_file($file)) {
            unlink($file);
        }
    }

    remove("airplanes", $id);

    header("location: index.php");
    exit;
}

function upload_image($file) {

    $targetDir = "../assets/avioes/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;

    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];

    if (!in_array($fileType, $allowedTypes)) {
        return null;
    }

    if ($file["size"] > 5 * 1024 * 1024) {
        return null;
    }

    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        return $fileName;
    }

    return null;
}
function formataData($data, $formato) {
    if (empty($data)) return null;
    try {
        $df = new DateTime($data, new DateTimeZone("America/Sao_Paulo"));
        return $df->format($formato);
    } catch (Exception $e) {
        return $data; 
    }
}
