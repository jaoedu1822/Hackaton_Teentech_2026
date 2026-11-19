<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$local = in_array($_SERVER['SERVER_ADDR'] ?? '', ['127.0.0.1', '::1'], true);

if ($local) {
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'zagatec';
} else {
    $host = 'seu_host_mysql';
    $user = 'seu_usuario_mysql';
    $pass = 'sua_senha_mysql';
    $db   = 'seu_banco_mysql';
}

$conn = new mysqli($host, $user, $pass, $db, 3306);
$conn->set_charset('utf8mb4');