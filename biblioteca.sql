-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Nov-2022 às 01:17
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `id_aluno` int(11) NOT NULL,
  `nome_aluno` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `senha` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de alunos';

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id_aluno`, `nome_aluno`, `email`, `senha`) VALUES
(1, 'Caio dos Santos Lopes', 'caio@gmail.com', '123'),
(2, 'Eduardo', 'eduardo@gmail.com', '123'),
(3, 'Mauro', 'mauro@gmail.com', '123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome_categoria` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome_categoria`) VALUES
(1, 'Literatura Brasileira'),
(2, 'Literatura Estrangeira'),
(3, 'Técnicos'),
(4, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gestor`
--

CREATE TABLE `gestor` (
  `id_gestor` int(11) NOT NULL,
  `nome_gestor` varchar(300) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de gestor';

--
-- Extraindo dados da tabela `gestor`
--

INSERT INTO `gestor` (`id_gestor`, `nome_gestor`, `usuario`, `senha`) VALUES
(1, 'Caio dos Santos Lopes', 'admin', 'etec');

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE `livro` (
  `id_livro` int(11) NOT NULL,
  `cod_livro` varchar(10) NOT NULL,
  `imagem` varchar(300) NOT NULL,
  `titulo` varchar(300) NOT NULL,
  `autor` varchar(300) NOT NULL,
  `cod_categoria` int(11) NOT NULL,
  `qtd_total` int(11) NOT NULL,
  `qtd_reserva` int(11) NOT NULL,
  `qtd_temp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de livros';

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`id_livro`, `cod_livro`, `imagem`, `titulo`, `autor`, `cod_categoria`, `qtd_total`, `qtd_reserva`, `qtd_temp`) VALUES
(15, '', '16674287696362f1a15cc3c.jpg', 'Todas as suas (im)perfeições', 'Colleen Hoover', 1, 10, 0, 0),
(16, '', '16674288336362f1e179995.jpg', 'A revolução dos bichos: Um conto de fadas', 'George Orwell', 2, 10, 0, 0),
(17, '', '16674288846362f2144ff4e.jpg', 'É Assim que Acaba: 1', 'Colleen Hoover', 3, 10, 0, 0),
(18, '', '16674289386362f24aa247a.jpg', 'Imperfeitos', 'Christina Lauren', 4, 10, 0, 0),
(19, '', '16674289796362f27372a75.jpg', 'Até o verão terminar', 'Colleen Hoover', 1, 10, 0, 0),
(20, '', '16674290376362f2adb5cda.jpg', 'Harry Potter e a Pedra Filosofal: 1', 'J.K. Rowling', 4, 10, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `registro`
--

CREATE TABLE `registro` (
  `id_registro` int(11) NOT NULL,
  `cod_aluno` int(11) NOT NULL,
  `cod_livro` int(11) NOT NULL,
  `data_da_reserva` date NOT NULL,
  `data_da_entrega` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(11) NOT NULL,
  `cod_aluno` int(11) NOT NULL,
  `cod_livro` int(11) NOT NULL,
  `data_da_reserva` date NOT NULL,
  `data_da_entrega` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva_temp`
--

CREATE TABLE `reserva_temp` (
  `id_temp` int(11) NOT NULL,
  `cod_livro` int(11) NOT NULL,
  `cod_aluno` int(11) NOT NULL,
  `data_hoje` datetime NOT NULL,
  `data_amanha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id_aluno`);

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `gestor`
--
ALTER TABLE `gestor`
  ADD PRIMARY KEY (`id_gestor`);

--
-- Índices para tabela `livro`
--
ALTER TABLE `livro`
  ADD PRIMARY KEY (`id_livro`);

--
-- Índices para tabela `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id_registro`);

--
-- Índices para tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_aluno` (`cod_aluno`),
  ADD KEY `fk_livro` (`cod_livro`);

--
-- Índices para tabela `reserva_temp`
--
ALTER TABLE `reserva_temp`
  ADD PRIMARY KEY (`id_temp`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `gestor`
--
ALTER TABLE `gestor`
  MODIFY `id_gestor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `livro`
--
ALTER TABLE `livro`
  MODIFY `id_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `reserva_temp`
--
ALTER TABLE `reserva_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_aluno` FOREIGN KEY (`cod_aluno`) REFERENCES `aluno` (`id_aluno`),
  ADD CONSTRAINT `fk_livro` FOREIGN KEY (`cod_livro`) REFERENCES `livro` (`id_livro`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `Check-reserva` ON SCHEDULE EVERY 24 HOUR STARTS '2022-10-25 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Evento que exclui reservas não efetuadas' DO DELETE FROM reserva_temp WHERE data_amanha <= now()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
