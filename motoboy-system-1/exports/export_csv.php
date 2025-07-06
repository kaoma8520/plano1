<?php
// export_csv.php

// Configurações de cabeçalho para exportação CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="relatorio_pedidos.csv"');

// Conexão com o banco de dados
require_once '../config/database.php';

// Criação do objeto PDO
$db = new PDO($dsn, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta para obter os pedidos
$query = "SELECT * FROM pedidos"; // Ajuste a consulta conforme necessário
$stmt = $db->prepare($query);
$stmt->execute();

// Obtenção dos dados
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Criação do arquivo CSV
$output = fopen('php://output', 'w');

// Cabeçalhos do CSV
fputcsv($output, array('ID', 'Cliente', 'Motoboy', 'Origem', 'Destino', 'Valor', 'Status', 'Data'));

// Adicionando os dados ao CSV
foreach ($pedidos as $pedido) {
    fputcsv($output, $pedido);
}

// Fechando o arquivo
fclose($output);
exit();
?>