-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Tempo de geração: 13/06/2025 às 23:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_filmes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_filmes`
--

CREATE TABLE `tb_filmes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `ano` int(11) NOT NULL,
  `genero` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_filmes`
--

INSERT INTO `tb_filmes` (`id`, `usuario_id`, `titulo`, `ano`, `genero`) VALUES
(1, 5, 'Drácula de Bram Stoker', 1992, 'Terror'),
(5, 5, 'Avatar', 2009, 'Ação'),
(6, 6, 'Vingadores: Ultimato', 2019, 'Ação'),
(7, 6, 'Titanic', 1997, 'Drama'),
(8, 6, 'Star Wars: O Despertar da Força', 2015, 'Ficção Científica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuarios`
--

CREATE TABLE `tb_usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`id`, `usuario`, `senha`, `email`) VALUES
(5, 'Teste123', '$2y$10$89T4ccnf3FX6VVnXo2Oeu.edTIV29CcfMlFddoh0D6X/peX2uEaTG', 'teste@teste.com'),
(6, 'Senha246', '$2y$10$U5WfZ2IsRB0c9bvTRh3dgu2Cczmoymtr.kxD5GlErq8ayavhoWbpG', 'senha246@teste.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_filmes`
--
ALTER TABLE `tb_filmes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_filmes`
--
ALTER TABLE `tb_filmes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_filmes`
--
ALTER TABLE `tb_filmes`
  ADD CONSTRAINT `tb_filmes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `tb_usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
