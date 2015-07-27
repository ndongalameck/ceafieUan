-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 27-Maio-2015 às 04:45
-- Versão do servidor: 5.5.40-0ubuntu0.14.04.1
-- versão do PHP: 5.5.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `ceafie`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE IF NOT EXISTS `aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `graduacao` varchar(45) NOT NULL,
  `universidade` varchar(45) NOT NULL,
  `unidade_organica` varchar(45) NOT NULL,
  `categoria_docente` varchar(45) NOT NULL,
  `funcao` varchar(45) NOT NULL,
  `categoria_cientifica` varchar(45) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aluno_pessoa_idx` (`pessoa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id`, `graduacao`, `universidade`, `unidade_organica`, `categoria_docente`, `funcao`, `categoria_cientifica`, `pessoa_id`) VALUES
(1, 'AUD', 'aaa', 'UAN', 'Associado', 'Chefe de departamento', 'Nenhuma', 129),
(4, 'as', 'sddfff', 'ADD', 'Associado', 'Chefe de departamento', 'Nenhuma', 140);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `descricao`, `nome`) VALUES
(14, 'Curso de Agregação Pedagogica', 'CAP'),
(15, 'Curso de Elaboracao de Projectos de Investiga', 'CEPID'),
(17, 'Curso de Elaboracao e Publicacao de Artigos C', 'CEPAC');

-- --------------------------------------------------------

--
-- Estrutura da tabela `docente`
--

CREATE TABLE IF NOT EXISTS `docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grau` varchar(45) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_docente_pessoa1_idx` (`pessoa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Extraindo dados da tabela `docente`
--

INSERT INTO `docente` (`id`, `grau`, `pessoa_id`) VALUES
(1, 'Mestre', 130),
(13, 'Licenciado', 152),
(24, 'Mestre', 163),
(25, 'Licenciado', 164);

-- --------------------------------------------------------

--
-- Estrutura da tabela `docentmodulo`
--

CREATE TABLE IF NOT EXISTS `docentmodulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_docentmodulo_modulo1_idx` (`modulo_id`),
  KEY `fk_docentmodulo_docente1_idx` (`docente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Extraindo dados da tabela `docentmodulo`
--

INSERT INTO `docentmodulo` (`id`, `modulo_id`, `docente_id`) VALUES
(4, 7, 13),
(21, 7, 24),
(22, 10, 24),
(23, 8, 24),
(24, 9, 24),
(25, 7, 25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `materia`
--

CREATE TABLE IF NOT EXISTS `materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(45) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`),
  KEY `fk_materia_curso1_idx` (`curso_id`),
  KEY `fk_materia_modulo1_idx` (`modulo_id`),
  KEY `fk_materia_docente1_idx` (`docente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `materia`
--

INSERT INTO `materia` (`id`, `data`, `curso_id`, `modulo_id`, `docente_id`, `nome`) VALUES
(1, '06-05-2015', 14, 7, 1, 'upload/10857787_400681220083985_1327457810813841755_n.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `matricula`
--

CREATE TABLE IF NOT EXISTS `matricula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `ano` varchar(40) NOT NULL,
  PRIMARY KEY (`id`,`modulo_id`),
  KEY `fk_matricula_aluno1_idx` (`aluno_id`),
  KEY `fk_matricula_curso1_idx` (`curso_id`),
  KEY `fk_matricula_modulo1_idx` (`modulo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `matricula`
--

INSERT INTO `matricula` (`id`, `data`, `estado`, `aluno_id`, `curso_id`, `modulo_id`, `ano`) VALUES
(1, '2015-05-18', 'FECHADO', 1, 14, 7, '2015'),
(4, '2015-05-20', 'FECHADO', 4, 14, 7, '2015');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `curso_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`),
  KEY `fk_modulo_curso1_idx` (`curso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `modulo`
--

INSERT INTO `modulo` (`id`, `nome`, `curso_id`) VALUES
(7, 'COMPUTAÇÃO', 14),
(8, 'Tecnicas e Linguagem de Programação', 15),
(9, 'Elaboração de projecto', 17),
(10, 'SEC', 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `nota`
--

CREATE TABLE IF NOT EXISTS `nota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nota` set('Excelente','Suficiente','Bom','') DEFAULT NULL,
  `data` varchar(45) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nota_aluno1_idx` (`aluno_id`),
  KEY `fk_nota_modulo1_idx` (`modulo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `nota`
--

INSERT INTO `nota` (`id`, `nota`, `data`, `aluno_id`, `modulo_id`) VALUES
(1, 'Bom', '2015-05-20', 1, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `genero` set('masculino','femenino') NOT NULL,
  `nacionalidade` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `imagem` varchar(5000) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `bi` varchar(45) NOT NULL,
  `documento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `telefone_UNIQUE` (`telefone`),
  UNIQUE KEY `bi_UNIQUE` (`bi`),
  UNIQUE KEY `unique_index` (`bi`,`documento`,`email`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=165 ;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `nome`, `genero`, `nacionalidade`, `telefone`, `imagem`, `email`, `bi`, `documento`) VALUES
(128, 'ADMINISTRADOR', 'masculino', 'ANGOLANA', '934895543', NULL, 'forksystem@gmail.com', '874567823LA032', NULL),
(129, 'Elone Sampaio', 'masculino', 'ANGOLANA', '984573449', 'upload/1902749_519278058210397_3315582850152740192_n.jpg', 'sadddmpaioelon@hotmail.com', '147593420LA032', NULL),
(130, 'Dario Germano', 'masculino', 'ANGOLANA', '236987653', NULL, 'samp3aioelon@hotmail.com', '224209345LA032', NULL),
(140, '    asdsam ass', 'masculino', 'ANGOLANA', '344443337', NULL, 'f2orksystem@gmail.com', '234209365LA031', NULL),
(152, 'addd aaaaaaaaa', 'masculino', 'ANGOLANA', '236987656', NULL, 'sa@fnf12.com', '234209345LA036', NULL),
(163, 'jsjjdjdjdjd sffhfhfhh', 'masculino', 'ANGOLANA', '238347748', NULL, '26363@gmail.com', '284209345LA032', NULL),
(164, 'shhhfhf skfkfkf', 'masculino', 'sjdjd', '324744844', NULL, '344@gmail.com', '234209355LA032', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `programa`
--

CREATE TABLE IF NOT EXISTS `programa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(50) NOT NULL,
  `local` varchar(45) DEFAULT NULL,
  `modulo_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `hora` varchar(250) DEFAULT NULL,
  `datafinal` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_programa_modulo1_idx` (`modulo_id`),
  KEY `fk_programa_docente1_idx` (`docente_id`),
  KEY `fk_programa_curso1_idx` (`curso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `programa`
--

INSERT INTO `programa` (`id`, `data`, `local`, `modulo_id`, `docente_id`, `curso_id`, `hora`, `datafinal`) VALUES
(1, '06-05-2015', 'Luanda', 7, 1, 14, '20h', '21-05-2015');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `nivel` set('administrador','aluno','docente','gestor') NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  `tema` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_pessoa1_idx` (`pessoa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `nivel`, `pessoa_id`, `tema`) VALUES
(36, 'admin', '9d32bccb306f7e1b3e737cecb07f8fc7', 'administrador', 128, 'metro'),
(37, 'sampaio', 'b78f3759dd139a3e9ce65aa0d190663a', 'aluno', 129, 'defaul'),
(38, 'Germano12', 'd4d95181cb245aa042c5482348ee941d', 'docente', 130, 'default'),
(41, 'ass8', '40a32f00ed095c0849251537d87ef330', 'aluno', 140, 'default'),
(44, 'aaaaaaaaa8', 'e4ed8359b8ac86c7c30cbcca44969b97', 'docente', 152, NULL),
(49, 'sffhfhfhh9', '38e9aa7935d57085b4c4a5ffe4bdae94', 'docente', 163, NULL),
(50, 'skfkfkf9', 'fd5f73bfed1e4e7bf2786a81383c0a63', 'docente', 164, NULL);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_aluno_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `fk_docente_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `docentmodulo`
--
ALTER TABLE `docentmodulo`
  ADD CONSTRAINT `fk_docentmodulo_docente1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_docentmodulo_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `fk_materia_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_materia_docente1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_materia_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `fk_matricula_aluno1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matricula_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matricula_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_modulo_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `fk_nota_aluno1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `programa`
--
ALTER TABLE `programa`
  ADD CONSTRAINT `fk_programa_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_programa_docente1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_programa_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
