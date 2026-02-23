<?php
include "config.php";
include DBAPI;

$db = open_database(); 

echo "<h1>Teste de Banco de Dados</h1><hr>";

if ($db) {
    echo "<p style='color:green;'><strong>Banco de Dados conectado com sucesso!</strong></p>";

    // Testa tabela customers
    echo "<h3>Tabela: customers</h3>";
    $sql = "SHOW TABLES LIKE 'customers'";
    $result = $db->query($sql);
    if ($result && $result->num_rows > 0) {
        echo "<p style='color:green;'>Tabela 'customers' encontrada </p>";
    } else {
        echo "<p style='color:red;'>Tabela 'customers' NÃO encontrada </p>";
    }

    echo "<h3>Tabela: airplanes</h3>";
    $sql = "SHOW TABLES LIKE 'airplanes'";
    $result = $db->query($sql);
    if ($result && $result->num_rows > 0) {
        echo "<p style='color:green;'>Tabela 'airplanes' encontrada </p>";
    } else {
        echo "<p style='color:red;'>Tabela 'airplanes' NÃO encontrada </p>";
    }

    $db->close();

} else {
    echo "<p style='color:red;'><strong>ERRO:</strong> Não foi possível conectar ao Banco de Dados!</p>";
}
?>
