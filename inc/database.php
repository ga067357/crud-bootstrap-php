<?php
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

/* ============================================================
   📌 ABRE CONEXÃO
   ============================================================ */
function open_database() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $conn->set_charset("utf8mb4");
        return $conn;
    } catch (Exception $e) {
        echo "Erro ao conectar: " . $e->getMessage();
        return null;
    }
}

/* ============================================================
   📌 FECHA CONEXÃO
   ============================================================ */
function close_database($conn) {
    try {
        mysqli_close($conn);
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
            $stmt = $database->prepare("SELECT * FROM {$table} WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $found = $stmt->get_result()->fetch_assoc();
            $stmt->close();

        } else {
            $result = $database->query("SELECT * FROM {$table}");

            if ($result->num_rows > 0) {
                $found = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
    } catch (Exception $e) {
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
        $result = $database->query($sql);

        if ($result->num_rows > 0) {
            $found = $result->fetch_all(MYSQLI_ASSOC);
        }

    } catch (Exception $e) {
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
        $types = "";

        foreach ($conditions as $col => $val) {
            $sql .= "{$col} = ? AND ";
            $params[] = $val;

            $types .= is_numeric($val) ? "i" : "s";
        }

        $sql = rtrim($sql, "AND ");

        $stmt = $database->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $found = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

    } catch (Exception $e) {
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

    $columns = implode(",", array_keys($data));
    $values  = "'" . implode("','", array_map('addslashes', array_values($data))) . "'";

    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

    try {
        $database->query($sql);
        $_SESSION["message"] = "Registro cadastrado com sucesso.";
        $_SESSION["type"] = "success";

    } catch (Exception $e) {
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

    $items = "";
    foreach ($data as $key => $value) {
        $items .= "{$key}='" . addslashes($value) . "',";
    }
    $items = rtrim($items, ",");

    $sql = "UPDATE {$table} SET {$items} WHERE id={$id}";

    try {
        $database->query($sql);
        $_SESSION['message'] = "Registro atualizado com sucesso.";
        $_SESSION['type'] = "success";

    } catch (Exception $e) {
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
            $stmt = $database->prepare("DELETE FROM {$table} WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['message'] = "Registro removido com sucesso.";
            $_SESSION['type'] = 'success';
        }

    } catch (Exception $e) {
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
