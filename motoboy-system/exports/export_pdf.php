<?php
require_once '../config/database.php';
require_once '../core/helpers.php';
require_once '../core/session.php';
require_once '../vendor/autoload.php'; // Certifique-se de ter o autoload do Composer para a biblioteca de PDF

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../admin/login.php');
    exit();
}

$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

// Consulta ao banco de dados para obter os dados a serem exportados
$query = "SELECT * FROM orders"; // Ajuste a consulta conforme necessário
$stmt = $pdo->prepare($query);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Montagem do HTML para o PDF
$html = '<h1>Relatório de Pedidos</h1>';
$html .= '<table border="1" cellpadding="5">';
$html .= '<thead><tr><th>ID</th><th>Cliente</th><th>Motoboy</th><th>Status</th><th>Data</th><th>Valor</th></tr></thead>';
$html .= '<tbody>';

foreach ($orders as $order) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($order['id']) . '</td>';
    $html .= '<td>' . htmlspecialchars($order['client_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($order['motoboy_name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($order['status']) . '</td>';
    $html .= '<td>' . htmlspecialchars($order['created_at']) . '</td>';
    $html .= '<td>' . htmlspecialchars($order['total']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';

// Carregar o HTML no Dompdf
$dompdf->loadHtml($html);

// (Opcional) Configurar o tamanho e a orientação do papel
$dompdf->setPaper('A4', 'landscape');

// Renderizar o PDF
$dompdf->render();

// Enviar o PDF para o navegador
$dompdf->stream('relatorio_pedidos.pdf', array('Attachment' => 0));
?>