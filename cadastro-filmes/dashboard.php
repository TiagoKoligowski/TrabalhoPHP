<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$conn = conectar_banco();

$mensagem = "";

// Cadastrar filme
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar_filme'])) {
    $titulo = trim($_POST['titulo']);
    $ano = trim($_POST['ano']);
    $genero = trim($_POST['genero']);
    $usuario_id = $_SESSION['usuario_id'];

    // Validação básica
    if (empty($titulo) || empty($ano) || empty($genero)) {
        $mensagem = '<div class="alert alert-danger">Preencha todos os campos obrigatórios para cadastrar o filme.</div>';
    } elseif (!is_numeric($ano) || $ano < 1800 || $ano > intval(date("Y")) + 1) {
        $mensagem = '<div class="alert alert-danger">Informe um ano válido para o filme.</div>';
    } else {
        // Inserir filme
        $sql = "INSERT INTO tb_filmes (titulo, ano, genero, usuario_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $titulo, $ano, $genero, $usuario_id);
        if ($stmt->execute()) {
            $mensagem = '<div class="alert alert-success">Filme cadastrado com sucesso!</div>';
        } else {
            $mensagem = '<div class="alert alert-danger">Erro ao cadastrar filme. Tente novamente.</div>';
        }
        $stmt->close();
    }
}

// Excluir filme
if (isset($_GET['excluir'])) {
    $filme_id = intval($_GET['excluir']);
    $usuario_id = $_SESSION['usuario_id'];

    // Só permite excluir se o filme pertence ao usuário logado
    $sql = "DELETE FROM tb_filmes WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $filme_id, $usuario_id);
    if ($stmt->execute()) {
        $mensagem = '<div class="alert alert-success">Filme excluído com sucesso!</div>';
    } else {
        $mensagem = '<div class="alert alert-danger">Erro ao excluir filme.</div>';
    }
    $stmt->close();
}

// Buscar filmes do usuário
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT id, titulo, ano, genero FROM tb_filmes WHERE usuario_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$filmes = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Meus Filmes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></h2>
    <a href="logout.php" class="btn btn-danger mb-4">Sair</a>

    <?= $mensagem ?>

    <h4>Cadastrar Novo Filme</h4>
    <form method="post" action="dashboard.php">
        <input type="hidden" name="cadastrar_filme" value="1">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo">
        </div>

        <div class="mb-3">
            <label for="ano" class="form-label">Ano de Lançamento:</label>
            <input type="number" class="form-control" id="ano" name="ano" min="1800" max="<?= date("Y") + 1 ?>">
        </div>

        <div class="mb-3">
            <label for="genero" class="form-label">Gênero:</label>
            <input type="text" class="form-control" id="genero" name="genero">
        </div>

        <button type="submit" class="btn btn-success">Cadastrar Filme</button>
    </form>

    <hr>

    <h4>Meus Filmes Cadastrados</h4>
    <?php if (count($filmes) === 0): ?>
        <p>Nenhum filme cadastrado ainda.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Ano</th>
                    <th>Gênero</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filmes as $filme): ?>
                <tr>
                    <td><?= htmlspecialchars($filme['titulo']) ?></td>
                    <td><?= htmlspecialchars($filme['ano']) ?></td>
                    <td><?= htmlspecialchars($filme['genero']) ?></td>
                    <td>
                        <a href="dashboard.php?excluir=<?= $filme['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este filme?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
