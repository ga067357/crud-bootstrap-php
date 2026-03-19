<?php

/* ============================================================
   📌 ABRE CONEXÃO (PDO)
   ============================================================ */
function open_database() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO($dsn, DB_USER, DB_PASSWORD, $options);

    } catch (PDOException $e) {
        echo "Erro ao conectar: " . $e->getMessage();
        return null;
    }
}

/* ============================================================
   📌 FECHA CONEXÃO (PDO)
   ============================================================ */
function close_database($conn) {
    try {
        $conn = null;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

/* ============================================================
   📌 BUSCA UM ITEM OU LISTA TODOS
   ============================================================ */
function find($table = null, $id = null) {
    $database = open_database();
    $found = null;

    try {
        if ($id) {
            $stmt = $database->prepare("SELECT * FROM {$table} WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $found = $stmt->fetch();

        } else {
            $stmt = $database->query("SELECT * FROM {$table}");
            $rows = $stmt->fetchAll();
            if ($rows) {
                $found = $rows;
            }
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
    return $found;
}

function find_all($table) {
    return find($table);
}

/* ============================================================
   📌 FUNÇÃO filter() — usada pelo módulo usuários
   ============================================================ */
function filter($table, $conditions) {
    $database = open_database();
    $found = [];

    try {
        $sql = "SELECT * FROM {$table} WHERE {$conditions}";
        $stmt = $database->query($sql);
        $rows = $stmt->fetchAll();
        if ($rows) {
            $found = $rows;
        }

    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro no filtro: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }

    close_database($database);
    return $found;
}

/* ============================================================
   📌 find_where() — forma segura de buscar com array
   ============================================================ */
function find_where($table, $conditions = []) {
    $database = open_database();
    $found = [];

    try {
        $sql = "SELECT * FROM {$table} WHERE ";
        $params = [];
        $i = 0;

        foreach ($conditions as $col => $val) {
            $ph = ":{$col}_{$i}";
            $sql .= "{$col} = {$ph} AND ";
            $params[$ph] = $val;
            $i++;
        }

        $sql = rtrim($sql, "AND ");

        $stmt = $database->prepare($sql);

        foreach ($params as $ph => $val) {
            $type = is_numeric($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue($ph, $val, $type);
        }

        $stmt->execute();
        $found = $stmt->fetchAll();
        $stmt->closeCursor();

    } catch (PDOException $e) {
        $_SESSION["message"] = "Erro ao buscar: " . $e->getMessage();
        $_SESSION["type"] = "danger";
    }

    close_database($database);
    return $found;
}

/* ============================================================
   📌 INSERT
   ============================================================ */
function save($table = null, $data = null) {
    $database = open_database();

    $columns = array_keys($data);
    $placeholders = array_map(function($c){ return ':' . $c; }, $columns);

    $sql = "INSERT INTO {$table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";

    try {
        $stmt = $database->prepare($sql);
        foreach ($data as $col => $val) {
            $type = is_numeric($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(':' . $col, $val, $type);
        }
        $stmt->execute();

        $_SESSION["message"] = "Registro cadastrado com sucesso.";
        $_SESSION["type"] = "success";

    } catch (PDOException $e) {
        $_SESSION["message"] = "Erro ao cadastrar: " . $e->getMessage();
        $_SESSION["type"] = "danger";
    }

    close_database($database);
}

/* ============================================================
   📌 UPDATE
   ============================================================ */
function update($table = null, $id = 0, $data = null) {
    $database = open_database();

    $items = [];
    foreach ($data as $key => $value) {
        $items[] = "{$key} = :{$key}";
    }

    $sql = "UPDATE {$table} SET " . implode(',', $items) . " WHERE id = :id";

    try {
        $stmt = $database->prepare($sql);
        foreach ($data as $col => $val) {
            $type = is_numeric($val) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $stmt->bindValue(':' . $col, $val, $type);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['message'] = "Registro atualizado com sucesso.";
        $_SESSION['type'] = "success";

    } catch (PDOException $e) {
        $_SESSION['message'] = "Erro ao atualizar: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }

    close_database($database);
}

/* ============================================================
   📌 DELETE
   ============================================================ */
function remove($table = null, $id = null) {
    $database = open_database();

    try {
        if ($id) {
            $stmt = $database->prepare("DELETE FROM {$table} WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['message'] = "Registro removido com sucesso.";
            $_SESSION['type'] = 'success';
        }

    } catch (PDOException $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }

    close_database($database);
}

/* ============================================================
   📌 CRIPTOGRAFIA — compatível com seu banco
   ============================================================ */
function criptografia($senha)
{
    return md5($senha);
}

?>
