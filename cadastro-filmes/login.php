<?php
session_start();
require_once 'includes/db.php';
$conn = conectar_banco();

if ($_SESSION['usuario_id']) {
    header("Location: dashboard.php");
    exit();
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    if (empty($usuario) || empty($senha)) {
        $mensagem = '<div class="alert alert-danger">Preencha todos os campos.</div>';
    } else {
        $sql = "SELECT id, senha FROM tb_usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $senhaHash);
            $stmt->fetch();

            if (password_verify($senha, $senhaHash)) {
                // Login válido, iniciar sessão
                $_SESSION['usuario_id'] = $id;
                $_SESSION['usuario_nome'] = $usuario;
                header("Location: dashboard.php"); // página após login
                exit();
            } else {
                $mensagem = '<div class="alert alert-danger">Senha incorreta.</div>';
            }
        } else {
            $mensagem = '<div class="alert alert-danger">Usuário não encontrado.</div>';
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 400px;">
    <h2>Login</h2>
    <?= $mensagem ?>
    <form method="post" action="login.php">
        <div class="mb-3">
            <label for="usuario" class="form-label">Nome de Usuário:</label>
            <input type="text" class="form-control" name="usuario" id="usuario">
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" name="senha" id="senha">
        </div>

        <button type="submit" class="btn btn-primary">Entrar</button>
        <a href="cadastro.php" class="btn btn-link">Cadastrar-se</a>
    </form>
</div>
</body>
</html>
