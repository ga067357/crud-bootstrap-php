<?php

require_once("../config.php");
require_once(DBAPI);

$usuarios = [];
$usuario = null;

/**
 * LISTAGEM
 */
function index()
{
    global $usuarios;

    if (!empty($_POST['users'])) {
        $busca = trim($_POST['users']);
        $usuarios = filter("usuarios", "nome LIKE '%$busca%' OR user LIKE '%$busca%'");
    } else {
        $usuarios = find_all("usuarios");
    }
}

/**
 * UPLOAD DE IMAGEM
 */
function upload_user_image($inputFile)
{
    try {
        if (empty($inputFile['name'])) return null;

        $pasta = "../assets/usuarios/";
        if (!is_dir($pasta)) mkdir($pasta, 0777, true);

        $ext = strtolower(pathinfo($inputFile['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];

        if (!in_array($ext, $allowed)) {
            throw new Exception("Formato de imagem não permitido.");
        }

        if ($inputFile['size'] > 5 * 1024 * 1024) {
            throw new Exception("Imagem acima do limite máximo de 5 MB.");
        }

        $nome = time() . "_" . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($inputFile['name']));
        $dest = $pasta . $nome;

        if (!move_uploaded_file($inputFile['tmp_name'], $dest)) {
            throw new Exception("Erro ao salvar a imagem.");
        }

        return $nome;

    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
        return null;
    }
}

/**
 * VERIFICA SE LOGIN EXISTE
 */
function login_exists($login, $ignoreId = null)
{
    $cond = "user = '$login'";

    if ($ignoreId !== null) {
        $cond .= " AND id != $ignoreId";
    }

    $result = filter("usuarios", $cond);
    return !empty($result);
}

/**
 * O SISTEMA TEM ALGUM ADMIN?
 */
function count_admins()
{
    $result = filter("usuarios", "nivel = 'admin'");
    return count($result);
}

/**
 * ADICIONAR USUÁRIO
 */
function add()
{
    if (!empty($_POST['usuario'])) {
        try {
            $usuario = $_POST['usuario'];

            $usuario['nome'] = trim($usuario['nome'] ?? '');
            $usuario['user'] = trim($usuario['user'] ?? '');

            if (empty($usuario['nome']) || empty($usuario['user'])) {
                throw new Exception("Nome e login são obrigatórios.");
            }

            // LOGIN DUPLICADO
            if (login_exists($usuario['user'])) {
                throw new Exception("Este login já está sendo usado.");
            }

            // FOTO
            if (!empty($_FILES['foto']['name'])) {
                $img = upload_user_image($_FILES['foto']);
                if ($img) $usuario['foto'] = $img;
            }

            // Nível (somente admin pode definir — assumindo que a página já usa requireAdmin)
            $usuario['nivel'] = ($usuario['nivel'] === 'admin') ? 'admin' : 'user';

            // SENHA obrigatória
            if (!empty($usuario['password'])) {
                $usuario['password'] = md5($usuario['password']);
            } else {
                throw new Exception("Senha é obrigatória.");
            }

            save('usuarios', $usuario);

            $_SESSION['message'] = "Usuário criado com sucesso.";
            $_SESSION['type'] = "success";
            header("Location: " . BASEURL . "usuarios/index.php");

            exit;

        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['type'] = "danger";
        }
    }
}

/**
 * EDITAR USUÁRIO
 */
function edit()
{
    try {
        if (!isset($_GET['id'])) {
            header("Location: index.php");
            exit;
        }

        $id = intval($_GET['id']);

        // evita admin alterar outro admin ou a si mesmo
        $userOriginal = find("usuarios", $id);

        if (empty($userOriginal)) {
            throw new Exception("Usuário inexistente.");
        }

        // POST => salvar alterações
        if (!empty($_POST['usuario'])) {

            $usuario = $_POST['usuario'];
            $usuario['nome'] = trim($usuario['nome'] ?? '');
            $usuario['user'] = trim($usuario['user'] ?? '');

            // LOGIN DUPLICADO
            if (login_exists($usuario['user'], $id)) {
                throw new Exception("Este login já está sendo usado por outro usuário.");
            }

            // SENHA opcional
            if (!empty($usuario['password'])) {
                $usuario['password'] = md5($usuario['password']);
            } else {
                unset($usuario['password']);
            }

            // Nível
            $usuario['nivel'] = ($usuario['nivel'] === 'admin') ? 'admin' : 'user';

            // Não permitir remover o último admin
            if ($userOriginal['nivel'] === 'admin'
                && $usuario['nivel'] === 'user'
                && count_admins() === 1) {
                throw new Exception("Não é possível rebaixar o último administrador do sistema.");
            }

            // FOTO
            if (!empty($_FILES['foto']['name'])) {
                $img = upload_user_image($_FILES['foto']);
                if ($img) {

                    // remove foto antiga
                    if (!empty($userOriginal['foto'])) {
                        $file = "../assets/usuarios/" . $userOriginal['foto'];
                        if (is_file($file)) unlink($file);
                    }

                    $usuario['foto'] = $img;
                }
            }

            update("usuarios", $id, $usuario);

            $_SESSION['message'] = "Usuário atualizado com sucesso.";
            $_SESSION['type'] = "success";
            header("Location: index.php");
            exit;

        } else {
            // GET: carregar dados
            global $usuario;
            $usuario = $userOriginal;
        }

    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = "danger";
    }
}

/**
 * VISUALIZAR
 */
function view($id = null)
{
    global $usuario;
    $usuario = find('usuarios', $id);
}

/**
 * DELETAR
 */
function delete($id = null)
{
    if (!$id) return;

    $user = find("usuarios", $id);

    if (!$user) return;

    // impedir excluir o único admin
    if ($user['nivel'] === 'admin' && count_admins() === 1) {
        $_SESSION['message'] = "Não é possível excluir o único administrador.";
        $_SESSION['type'] = "danger";
        header("Location: index.php");
        exit;
    }

    // remover foto
    if (!empty($user['foto'])) {
        $file = "../assets/usuarios/" . $user['foto'];
        if (is_file($file)) unlink($file);
    }

    remove("usuarios", $id);

    $_SESSION['message'] = "Usuário removido com sucesso.";
    $_SESSION['type'] = "success";

    header("Location: index.php");
    exit;
}

/**
 * LIMPAR IMAGENS SEM USO
 */
function deleteUnusedImg()
{
    // pega todos os usuários (sem filtro!)
    $todos = find_all("usuarios");

    $pasta = '../assets/usuarios/';
    if (!is_dir($pasta)) return;

    $arquivos = scandir($pasta);
    $imgsAtivas = [];

    foreach ($todos as $u) {
        if (!empty($u['foto'])) $imgsAtivas[] = $u['foto'];
    }

    foreach ($arquivos as $img) {
        if ($img === '.' || $img === '..') continue;

        $arquivo = $pasta . $img;
        if (!is_file($arquivo)) continue;

        if (!in_array($img, $imgsAtivas)) {
            unlink($arquivo);
        }
    }
}
