<?php
session_start();
require_once 'includes/db.php'; // Arquivo com a conexão ao banco
$conn = conectar_banco();
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    // Validação básica
    if (empty($usuario) || empty($email) || empty($senha)) {
        $mensagem = '<div class="alert alert-danger">Preencha todos os campos obrigatórios.</div>';
    } else {
        // Verificar se o usuário já existe
        $sql = "SELECT id FROM tb_usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $mensagem = '<div class="alert alert-warning">Este nome de usuário já está em uso.</div>';
        } else {
            // Criptografar a senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir usuário no banco
            $sql = "INSERT INTO tb_usuarios (usuario, senha, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $usuario, $senhaHash, $email);

            if ($stmt->execute()) {
                $mensagem = '<div class="alert alert-success">Usuário cadastrado com sucesso! <a href="login.php">Clique aqui para fazer login</a>.</div>';
            } else {
                $mensagem = '<div class="alert alert-danger">Erro ao cadastrar. Tente novamente.</div>';
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Cadastro de Novo Usuário</h2>
    <?= $mensagem ?>
    <form method="post" action="cadastro.php">
        <div class="mb-3">
            <label for="usuario" class="form-label">Nome de Usuário:</label>
            <input type="text" class="form-control" name="usuario" id="usuario">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" name="senha" id="senha">
        </div>

        <button type="submit" class="btn btn-success">Cadastrar</button>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
