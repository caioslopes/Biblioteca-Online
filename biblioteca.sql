-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Dez-2022 às 22:40
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
  `senha` varchar(45) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de alunos';

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id_aluno`, `nome_aluno`, `email`, `senha`, `status`) VALUES
(7, 'Caio dos Santos Lopes', 'caio@gmail.com', 'caio', 0),
(8, 'Gustavo Francisco da Silva Costa Gusmao', 'gustavosilva200794@gmail.com', '123', 0),
(9, 'teste', 'teste@gmail.com', '123', 0),
(10, 'amanda lemoss', 'Amanda@gmail.com', '123', 0),
(11, 'Champola Beira-Mar', 'joao.francisco12123@gmail.com', 'joaobrbr123', 0),
(12, 'LARISSA TITATO', 'LARISSATITATOESC@GMAIL.COM', '20230524LTP', 0),
(13, 'Guilherme Crecenzi', 'guilherme@gmail.com', '123', 0),
(14, 'teste', 'mauro@gmail.com', '123', 0),
(15, 'daniel savioli', 'daniel_savioli@hotmail.com', 'teste1234', 0),
(16, 'mauro', 'topp@gmail.com', '123', 0),
(17, '0', 'gabrielreverse1@gmail', 'hh', 0),
(18, 'Eduardo Pires Carvalho', 'epc4129@gmail.com', '123', 0),
(19, 'Letícia Pires de Souza', 'leticiapires_souza@outlook.com', 'Colombo@22', 0),
(21, 'Caio dos Santos Lopes', 'caiolopes.social@gmail.com', '123', 0),
(22, 'asdasd', 'asdas@gmail.com', '123', 0),
(23, 'João Brito Alencar do Santos Almeida', 'joao@gmail.com', '123', 0);

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
  `imagem` varchar(300) NOT NULL,
  `titulo` varchar(300) NOT NULL,
  `autor` varchar(300) NOT NULL,
  `cod_categoria` int(11) NOT NULL,
  `paginas` int(11) NOT NULL,
  `sinopse` longtext NOT NULL,
  `qtd_total` int(11) NOT NULL,
  `qtd_reserva` int(11) NOT NULL,
  `qtd_temp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabela de livros';

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`id_livro`, `imagem`, `titulo`, `autor`, `cod_categoria`, `paginas`, `sinopse`, `qtd_total`, `qtd_reserva`, `qtd_temp`) VALUES
(28, '1667956969636b00e961039.jpg', 'A Menina Que Roubava Livros', 'Markus Zusak', 2, 0, 'A trajetória de Liesel Meminger é contada por uma narradora mórbida, surpreendentemente simpática. Ao perceber que a pequena ladra de livros lhe escapa, a Morte afeiçoa-se à menina e rastreia suas pegadas de 1939 a 1943. Traços de uma sobrevivente: a mãe comunista, perseguida pelo nazismo, envia Liesel e o irmão para o subúrbio pobre de uma cidade alemã, onde um casal se dispõe a adotá-los por dinheiro. O garoto morre no trajeto e é enterrado por um coveiro que deixa cair um livro na neve. É o primeiro de uma série que a menina vai surrupiar ao longo dos anos. O único vínculo com a família é esta obra, que ela ainda não sabe ler.\r\n\r\nAssombrada por pesadelos, ela compensa o medo e a solidão das noites com a conivência do pai adotivo, um pintor de parede bonachão que lhe dá lições de leitura. Alfabetizada sob vistas grossas da madrasta, Liesel canaliza urgências para a literatura. Em tempos de livros incendiados, ela os furta, ou os lê na biblioteca do prefeito da cidade.\r\n\r\nA vida ao redor é a pseudo-realidade criada em torno do culto a Hitler na Segunda Guerra. Ela assiste à eufórica celebração do aniversário do Führer pela vizinhança. Teme a dona da loja da esquina, colaboradora do Terceiro Reich. Faz amizade com um garoto obrigado a integrar a Juventude Hitlerista. E ajuda o pai a esconder no porão um judeu que escreve livros artesanais para contar a sua parte naquela História. A Morte, perplexa diante da violência humana, dá um tom leve e divertido à narrativa deste duro confronto entre a infância perdida e a crueldade do mundo adulto, um sucesso absoluto - e raro - de crítica e público.', 10, 0, 2),
(29, '1667957055636b013fe1a80.jpg', '1984', 'George Orwell', 2, 0, '', 10, 0, 0),
(30, '1667957107636b017347f83.jpg', 'A revolução dos bichos: Um conto de fadas', 'George Orwell', 2, 0, '', 10, 0, 0),
(31, '1667957465636b02d9dbd23.jpg', 'O Povo Brasileiro: A Formação e o Sentido do Brasil', 'Darcy Ribeiro ', 1, 0, '', 10, 0, 0),
(32, '1667957507636b030341e79.jpg', 'Fahrenheit 451', 'Ray Bradbury', 2, 0, '', 10, 0, 1),
(33, '1667957534636b031e44fd8.jpg', 'Torto arado ', 'Itamar Vieira Junior', 1, 0, '', 10, 0, 0),
(34, '1667957566636b033e4b586.jpg', 'Maus', 'Art Spiegelman', 2, 0, '', 10, 0, 0),
(35, '1667957590636b035685b21.jpg', 'Vidas secas', 'Graciliano Ramos ', 1, 0, '', 10, 0, 0),
(36, '1667957639636b0387bbcb1.jpg', 'Helena', 'Machado de Assis ', 1, 0, '', 10, 0, 0),
(37, '1667957654636b039683ecd.jpg', 'Saboroso Cadáver', 'Ayelén Medail', 2, 0, '', 10, 0, 0),
(38, '1667957687636b03b780030.jpg', 'Os sertões', 'Euclides da Cunha', 1, 0, '', 10, 0, 0),
(39, '1667957746636b03f26f424.jpg', 'Dom Casmurro', 'Machado de Assis ', 1, 0, '', 10, 0, 0),
(40, '1667957819636b043b41814.jpg', 'Introdução à Linguagem SQL: Abordagem Prática Para Iniciantes', 'Thomas Nield', 3, 0, '', 10, 0, 0),
(42, '1667957951636b04bf2b3ea.jpg', 'Programação funcional para leigos', 'John Paul Mueller', 3, 0, '', 10, 0, 0),
(43, '1667957987636b04e3d0317.jpg', 'É Assim que Acaba', 'Colleen Hoover ', 4, 0, '', 10, 0, 0),
(44, '1667958028636b050c0f41d.jpg', 'E não sobrou nenhum', 'Agatha Christie', 4, 0, '', 10, 0, 0),
(45, '1667958036636b05144d938.jpg', 'Administração: Teoria e Prática no Contexto Brasileiro', 'Filipe Sobral ', 3, 0, '', 10, 0, 0),
(46, '1667958073636b053980809.jpg', 'Mulheres que correm com os lobos', 'Clarissa Pinkola Estés', 4, 0, '', 10, 0, 0),
(47, '1667958108636b055c8c7c2.jpg', 'A Invalidade do Negócio Jurídico - 2° Edição', 'Maurício Bunazar', 3, 0, '', 10, 0, 0),
(48, '1667958113636b056175ef3.jpg', 'A Biblioteca da Meia-Noite', 'Matt Haig', 4, 0, '', 10, 0, 0),
(49, '1667958193636b05b197a42.jpg', 'Neon Genesis Evangelion', 'Yoshiyuki Sadamoto', 4, 0, '', 10, 0, 0),
(50, '1667958195636b05b3e9ecc.jpg', 'Teoria da Argumentação Jurídica', 'Robert ALEXY', 3, 0, '', 10, 0, 0),
(51, '1667958349636b064d71b24.jpg', 'Estruturas de Dados e Algoritmos com JavaScript', 'Loiane Groner', 3, 0, '', 10, 0, 0),
(52, '1667958482636b06d26aa12.jpg', 'Mindset: A nova psicologia do sucesso', 'Carol S. Dweck', 4, 0, '', 10, 0, 0),
(53, '16698567916387fe17d9b8d.jpg', 'Hunter X Hunter - Vol. 35', 'Yoshihiro Togashi', 2, 208, '', 10, 0, 0);

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
-- Extraindo dados da tabela `reserva_temp`
--

INSERT INTO `reserva_temp` (`id_temp`, `cod_livro`, `cod_aluno`, `data_hoje`, `data_amanha`) VALUES
(86, 32, 14, '2022-12-02 17:50:00', '2022-12-03 17:50:00');

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
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de tabela `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `reserva_temp`
--
ALTER TABLE `reserva_temp`
  MODIFY `id_temp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

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
