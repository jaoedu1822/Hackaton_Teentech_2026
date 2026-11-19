<?php
session_start();
require "conexao.php";

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

$stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();

if ($usuario && password_verify($senha, $usuario["senha"])) {
    // Marca a sessão como logada (menu + acompanhar caso usam isso)
    $_SESSION["logado"] = true;
    $_SESSION["usuario_id"] = $usuario["id"];

    // Se tentou acompanhar caso antes de logar, volta para lá
    if (!empty($_SESSION["redirect_depois_login"])) {
        $destino = $_SESSION["redirect_depois_login"];
        unset($_SESSION["redirect_depois_login"]);
        header("Location: " . $destino);
        exit;
    }

    header("Location: index.php");
    exit;
}

header("Location: login.php?erro=1");
exit;
