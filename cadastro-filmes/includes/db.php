<?php

function conectar_banco(){

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

    return $conn;
}
?>
