-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 19/06/2015 às 00:55
-- Versão do servidor: 5.5.40-0ubuntu0.14.04.1
-- Versão do PHP: 5.5.19-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `ceafie`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Fazendo dump de dados para tabela `aluno`
--

INSERT INTO `aluno` (`id`, `graduacao`, `universidade`, `unidade_organica`, `categoria_docente`, `funcao`, `categoria_cientifica`, `pessoa_id`) VALUES
(49, 'AUD', 'assd', 'ADD', 'Nenhum', 'Chefe de seccao', 'Nenhuma', 235);

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Fazendo dump de dados para tabela `curso`
--

INSERT INTO `curso` (`id`, `descricao`, `nome`) VALUES
(14, 'Curso de AgregaÃ§Ã£o Pedagogica', 'CAP'),
(15, 'Curso de Elaboracao de Projectos de Investiga', 'CEPID'),
(17, 'Curso de Elaboracao e Publicacao de Artigos C', 'CEPAC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `docente`
--

CREATE TABLE IF NOT EXISTS `docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grau` varchar(45) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_docente_pessoa1_idx` (`pessoa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `docentmodulo`
--

CREATE TABLE IF NOT EXISTS `docentmodulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modulo_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_docentmodulo_modulo1_idx` (`modulo_id`),
  KEY `fk_docentmodulo_docente1_idx` (`docente_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `materia`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `matricula`
--

CREATE TABLE IF NOT EXISTS `matricula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_matricula_aluno1_idx` (`aluno_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Fazendo dump de dados para tabela `matricula`
--

INSERT INTO `matricula` (`id`, `data`, `estado`, `aluno_id`) VALUES
(44, '03-06-2015', 'FECHADO', 49);

-- --------------------------------------------------------

--
-- Estrutura para tabela `matricula_modulo`
--

CREATE TABLE IF NOT EXISTS `matricula_modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `data` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_matricula_modulo_matricula1_idx` (`matricula_id`),
  KEY `fk_matricula_modulo_modulo1_idx` (`modulo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Fazendo dump de dados para tabela `matricula_modulo`
--

INSERT INTO `matricula_modulo` (`id`, `matricula_id`, `modulo_id`, `data`) VALUES
(15, 44, 7, '03-06-2015'),
(25, 44, 8, '18-06-2015');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `curso_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`),
  KEY `fk_modulo_curso1_idx` (`curso_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Fazendo dump de dados para tabela `modulo`
--

INSERT INTO `modulo` (`id`, `nome`, `curso_id`) VALUES
(7, 'COMPUTAÇÃO', 14),
(8, 'Tecnicas e Linguagem de Programação', 15),
(9, 'Elaboração de projecto', 17),
(12, 'Telecomunicações', 14),
(14, 'Tecnologia de Rede', 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Fazendo dump de dados para tabela `nota`
--

INSERT INTO `nota` (`id`, `nota`, `data`, `aluno_id`, `modulo_id`) VALUES
(15, 'Suficiente', '2015-06-18', 49, 7),
(17, 'Bom', '2015-06-18', 49, 8);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `genero` set('masculino','femenino') DEFAULT NULL,
  `nacionalidade` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `imagem` varchar(5000) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `bi` varchar(45) DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bi_UNIQUE` (`bi`),
  UNIQUE KEY `telefone_UNIQUE` (`telefone`),
  UNIQUE KEY `unique_index` (`bi`,`documento`,`email`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=253 ;

--
-- Fazendo dump de dados para tabela `pessoa`
--

INSERT INTO `pessoa` (`id`, `nome`, `genero`, `nacionalidade`, `telefone`, `imagem`, `email`, `bi`, `documento`) VALUES
(128, 'ADMINISTRADOR', 'masculino', 'ANGOLANA', '934895543', NULL, 'forksystem@gmail.com', '874567823LA032', NULL),
(235, 'Elone Miguel', 'masculino', 'ANGOLANA', '344443339', 'upload/1902749_519278058210397_3315582850152740192_n.jpg', 'samp3aioelon@hotmail.com', '347593420LA035', NULL),
(250, 'ADMINISTRADOR', 'masculino', 'ANGOLANA', '222', 's33', 'sdd', 'eee', 'ee'),
(251, 'teste14', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(252, 'teste24', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `programa`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `login`, `senha`, `nivel`, `pessoa_id`, `tema`) VALUES
(36, 'admin', '9d32bccb306f7e1b3e737cecb07f8fc7', 'gestor', 128, 'metro'),
(62, 'Samuel6', '9d0f572d371c1f6d6115a77d316cb807', 'aluno', 235, NULL),
(78, 'administrador', '9d32bccb306f7e1b3e737cecb07f8fc7', 'administrador', 250, NULL),
(79, 'teste14', '94b0d83638274bd78acb1cabdd76b1d4', 'administrador', 251, NULL),
(80, 'teste25', '40a32f00ed095c0849251537d87ef330', 'administrador', 252, NULL);

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_aluno_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `fk_docente_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `docentmodulo`
--
ALTER TABLE `docentmodulo`
  ADD CONSTRAINT `fk_docentmodulo_docente1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_docentmodulo_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `fk_materia_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_materia_docente1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_materia_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `fk_matricula_aluno1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `matricula_modulo`
--
ALTER TABLE `matricula_modulo`
  ADD CONSTRAINT `fk_matricula_modulo_matricula1` FOREIGN KEY (`matricula_id`) REFERENCES `matricula` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matricula_modulo_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_modulo_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `fk_nota_aluno1` FOREIGN KEY (`aluno_id`) REFERENCES `aluno` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `programa`
--
ALTER TABLE `programa`
  ADD CONSTRAINT `fk_programa_curso1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_programa_docente1` FOREIGN KEY (`docente_id`) REFERENCES `docente` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_programa_modulo1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
