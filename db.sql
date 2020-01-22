------------------------------------------------------

--
-- Estrutura da tabela `avaliador`
--

DROP TABLE IF EXISTS `avaliador`;
CREATE TABLE IF NOT EXISTS `avaliador` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `aemail` varchar(50) NOT NULL,
  `anome` varchar(50) NOT NULL,
  `ccategoria` text NOT NULL,
  `asenha` text NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `avaliador`
--

INSERT INTO `avaliador` (`aid`, `aemail`, `anome`, `ccategoria`, `asenha`) VALUES
(1, 'astrofotografia@nrolabs.com', 'Avaliador', 'Planetarias', 'astrofotografia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `captura`
--

DROP TABLE IF EXISTS `captura`;
CREATE TABLE IF NOT EXISTS `captura` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cpontos` int(11) DEFAULT NULL,
  `cautor` text NOT NULL,
  `ctitulo` text NOT NULL,
  `ccategoria` text NOT NULL,
  `cdescricao` text NOT NULL,
  `csrcfull` text NOT NULL,
  `csrcsmall` text NOT NULL,
  `cstatus` int(11) NOT NULL,
  `cdata` datetime NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--


DROP TABLE IF EXISTS `editorial`;
CREATE TABLE IF NOT EXISTS `editorial` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `eemail` varchar(50) NOT NULL,
  `enome` varchar(50) NOT NULL,
  `esenha` text NOT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `editorial`
--

INSERT INTO `editorial` (`eid`, `eemail`, `enome`, `esenha`) VALUES
(1, 'astrofotografia@nrolabs.com', 'Editorial', 'astrofotografia ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys`
--

DROP TABLE IF EXISTS `sys`;
CREATE TABLE IF NOT EXISTS `sys` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `aid` varchar(50) NOT NULL,
  `cid` varchar(20) NOT NULL,
  `cpontos` int(11) DEFAULT NULL,
  `sstatus` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--


DROP TABLE IF EXISTS `upload`;
CREATE TABLE IF NOT EXISTS `upload` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uemail` varchar(50) NOT NULL,
  `unome` varchar(50) NOT NULL,
  `usenha` text NOT NULL,
  `ustatus` int(11) NOT NULL,
  `udata` datetime NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `upload`
--