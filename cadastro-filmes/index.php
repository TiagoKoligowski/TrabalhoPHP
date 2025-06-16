<?php
session_start();

// Se o usuário já estiver logado, redireciona para o dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Filmes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="text-center">
        <h1 class="mb-4">🎬 Sistema de Cadastro de Filmes</h1>
        <p>Bem-vindo! Cadastre-se ou entre para gerenciar seus filmes favoritos.</p>
        <a href="login.php" class="btn btn-primary m-2">Login</a>
        <a href="cadastro.php" class="btn btn-success m-2">Cadastrar-se</a>
    </div>
</div>

</body>
</html>
