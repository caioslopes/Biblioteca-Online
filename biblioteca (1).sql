-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Out-2022 às 19:12
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
(1, 'Caio dos Santos Lopes', 'caiolopes.social@gmail.com', '123');

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
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de livros';

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`id_livro`, `cod_livro`, `imagem`, `titulo`, `autor`, `cod_categoria`, `quantidade`) VALUES
(11, '00000', '166534713563432e3fd40a5.jpg', 'Mico', 'Anne Frank', 2, 10),
(12, '01901', '166534710463432e2099437.jpg', 'A menina que Roubava Livros', 'Clarice Lispector', 3, 10);

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

--
-- Extraindo dados da tabela `registro`
--

INSERT INTO `registro` (`id_registro`, `cod_aluno`, `cod_livro`, `data_da_reserva`, `data_da_entrega`) VALUES
(1, 1, 11, '2022-10-13', '2022-10-23'),
(2, 1, 11, '2022-10-13', '2022-10-23'),
(3, 1, 11, '2022-10-19', '2022-10-31');

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
  `id_reserva` int(11) NOT NULL,
  `cod_livro` int(11) NOT NULL,
  `cod_aluno` int(11) NOT NULL,
  `data_hoje` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_amanha` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `reserva_temp`
--

INSERT INTO `reserva_temp` (`id_reserva`, `cod_livro`, `cod_aluno`, `data_hoje`, `data_amanha`) VALUES
(4, 11, 1, '19/10/2022', '20/10/2022');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id_aluno`);

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
  ADD PRIMARY KEY (`id_reserva`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `gestor`
--
ALTER TABLE `gestor`
  MODIFY `id_gestor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `livro`
--
ALTER TABLE `livro`
  MODIFY `id_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `reserva_temp`
--
ALTER TABLE `reserva_temp`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_aluno` FOREIGN KEY (`cod_aluno`) REFERENCES `aluno` (`id_aluno`),
  ADD CONSTRAINT `fk_livro` FOREIGN KEY (`cod_livro`) REFERENCES `livro` (`id_livro`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
