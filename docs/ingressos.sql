-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 19-Nov-2014 às 02:16
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ingressos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth`
--

CREATE TABLE IF NOT EXISTS `auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(15) NOT NULL,
  `pw` varchar(60) NOT NULL,
  `isAdm` bit(1) NOT NULL,
  `userCpf` bigint(11) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  KEY `fk_userCpf_idx` (`userCpf`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `auth`
--

INSERT INTO `auth` (`id`, `login`, `pw`, `isAdm`, `userCpf`) VALUES
(2, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', b'1', 04763305999),
(4, 'pati.santos', '07ec938e9b4719cff2fed1b601ff4246169a3517', b'1', 06499454923);

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogo`
--

CREATE TABLE IF NOT EXISTS `jogo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomeTime1` varchar(45) NOT NULL,
  `nomeTime2` varchar(45) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `local` varchar(255) NOT NULL,
  `vagas` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_time1_idx` (`nomeTime1`),
  KEY `fk_time2_idx` (`nomeTime2`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1005 ;

--
-- Extraindo dados da tabela `jogo`
--

INSERT INTO `jogo` (`id`, `nomeTime1`, `nomeTime2`, `data`, `hora`, `local`, `vagas`) VALUES
(1001, 'Irã', 'Nigéria', '2014-11-18', '16:00:00', 'Arena, Curitiba PR', 25000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sorteio`
--

CREATE TABLE IF NOT EXISTS `sorteio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `id_responsavel` bigint(11) unsigned zerofill NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `sorteados` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_responsavel_UNIQUE` (`id_responsavel`),
  KEY `fk_jogoSorteio_idx` (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ticket`
--

CREATE TABLE IF NOT EXISTS `ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(11) unsigned zerofill NOT NULL,
  `id_jogo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_usuario_UNIQUE` (`id_usuario`),
  KEY `fk_jogo_idx` (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `time`
--

CREATE TABLE IF NOT EXISTS `time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `NOMETIME` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `time`
--

INSERT INTO `time` (`id`, `nome`) VALUES
(8, 'Argélia'),
(4, 'Austrália'),
(7, 'Equador'),
(5, 'Espanha'),
(6, 'Honduras'),
(2, 'Irã'),
(3, 'Nigéria'),
(9, 'Rússia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `cpf` bigint(11) unsigned zerofill NOT NULL,
  `nome` varchar(255) NOT NULL,
  `rg` varchar(45) NOT NULL,
  `dataNasc` date NOT NULL,
  `cep` bigint(10) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numEndereco` int(5) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `jogo1` int(11) DEFAULT NULL,
  `jogo2` int(11) DEFAULT NULL,
  `jogo3` int(11) DEFAULT NULL,
  `sorteado` bit(1) NOT NULL,
  PRIMARY KEY (`cpf`),
  KEY `fk_jogo1_idx` (`jogo1`),
  KEY `fk_jogo2_idx` (`jogo2`),
  KEY `fk_jogo3_idx` (`jogo3`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`cpf`, `nome`, `rg`, `dataNasc`, `cep`, `endereco`, `numEndereco`, `bairro`, `cidade`, `estado`, `jogo1`, `jogo2`, `jogo3`, `sorteado`) VALUES
(04763305999, 'Evandro Morini Silva', '62446005', '1985-08-19', 81130200, 'Rua José Rodrigues Pinheiro', 1431, 'Capão Raso', 'Curitiba', 'PR', NULL, NULL, NULL, b'0'),
(06499454923, 'Patrícia Pacheco dos Santos', '85564447', '1987-11-15', 81130200, 'Rua José Rodrigues Pinheiro', 1431, 'Capão Raso', 'Curitiba', 'PR', NULL, NULL, NULL, b'0');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `auth`
--
ALTER TABLE `auth`
  ADD CONSTRAINT `fk_userCpf` FOREIGN KEY (`userCpf`) REFERENCES `usuario` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `jogo`
--
ALTER TABLE `jogo`
  ADD CONSTRAINT `fk_time1` FOREIGN KEY (`nomeTime1`) REFERENCES `time` (`nome`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_time2` FOREIGN KEY (`nomeTime2`) REFERENCES `time` (`nome`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `sorteio`
--
ALTER TABLE `sorteio`
  ADD CONSTRAINT `fk_jogoSorteio` FOREIGN KEY (`id_jogo`) REFERENCES `jogo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarioSorteio` FOREIGN KEY (`id_responsavel`) REFERENCES `usuario` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `fk_jogo` FOREIGN KEY (`id_jogo`) REFERENCES `jogo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_jogo1` FOREIGN KEY (`jogo1`) REFERENCES `jogo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jogo2` FOREIGN KEY (`jogo2`) REFERENCES `jogo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jogo3` FOREIGN KEY (`jogo3`) REFERENCES `jogo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
