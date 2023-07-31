<?php

// On interdit toute méthode qui n'est pas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Méthode non autorisée'], JSON_UNESCAPED_UNICODE);
} else {
    require_once('../private/inc.php');
    $navigator = new Navigator();
    $navigator->getApi($_POST['service'] ?? null);
}
