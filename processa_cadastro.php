<?php
require "conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Só aceita acesso vindo do formulário (POST)
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastro.php");
    exit;
}

$email   = trim($_POST["email"] ?? "");
$senha   = $_POST["senha"] ?? "";
$confirm = $_POST["confirm"] ?? "";
$termos  = isset($_POST["terms"]);
 
// ===== Validações (o servidor sempre confere, mesmo que o JavaScript já tenha conferido) =====
if ($email === "" || $senha === "" || $confirm === "") {
    header("Location: cadastro.php?erro=vazio");
    exit;
}
 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: cadastro.php?erro=email");
    exit;
}
 
if (strlen($senha) < 8) {
    header("Location: cadastro.php?erro=curta");
    exit;
}
 
if ($senha !== $confirm) {
    header("Location: cadastro.php?erro=diferente");
    exit;
}
 
if (!$termos) {
    header("Location: cadastro.php?erro=termos");
    exit;
}
 
// ===== Esse e-mail já existe? =====
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
 
if ($stmt->num_rows > 0) {
    header("Location: cadastro.php?erro=existe");
    exit;
}
$stmt->close();
 
// ===== Salva no banco (a senha vai como hash, nunca pura) =====
$hash = password_hash($senha, PASSWORD_DEFAULT);
 
try {
    $stmt = $conn->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hash);
 
    if ($stmt->execute()) {
        header("Location: login.php?cadastro=ok");
    } else {
        header("Location: cadastro.php?erro=banco");
    }
} catch (mysqli_sql_exception $e) {
    header("Location: cadastro.php?erro=banco");
}
exit;
 