<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'bd_filmes';
$porta = 3307;

$conn = new mysqli($servidor, $usuario, $senha, $banco, $porta);

    // Verificar conexão
if (!$conn) {
    exit("Falha na conexão: " . $conn->connect_error);
}

echo "✅ Conexão com o banco de dados realizada com sucesso!"; // Apenas para validar se a conexão foi realizada, não é utilizado no código.
?>