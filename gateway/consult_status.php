<?php
header("Content-Type: application/json");
include_once('../isis@angeline/services/database.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['code'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Código não fornecido.']);
    exit;
}

$code = $data['code'];

global $mysqli;
$stmt = $mysqli->prepare("SELECT status FROM transacoes WHERE code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();
$stmt->close();

if (!isset($status)) {
    echo json_encode(['result' => false]);
    exit;
}

if ($status == 'pago' || $status == '1') {
    echo json_encode(['result' => true]);
} else {
    echo json_encode(['result' => false]);
}
