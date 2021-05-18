CREATE DATABASE PwsAeroporto;
USE PwsAeroporto;

Create table if not exists Utilizadores(
	IdUtilizador INT UNSIGNED AUTO_INCREMENT,
    NomeCompleto VARCHAR(100) NOT NULL,
    DataNascimento Date NOT NULL,
	Email VARCHAR(100) NOT NULL,
	Telefone VARCHAR(20) NOT NULL,
    Utilizador VARCHAR(100) NOT NULL,
    PasswordUtilizador VARCHAR(100) NOT NULL,
    Perfil VARCHAR(100) NOT NULL,
	CONSTRAINT pk_Utilizadores_IdUtilizador PRIMARY KEY(IdUtilizador)
)ENGINE=InnoDB;

Create table if not exists Aeroportos(
	IdAeroporto INT UNSIGNED AUTO_INCREMENT,
    NomeAeroporto varchar(100) not null,
    Pais varchar(100) not null,
    Cidade varchar(100) not null,
	CONSTRAINT pk_Aeroportos_IdVoo PRIMARY KEY(IdAeroporto)
)ENGINE=InnoDB;

Create table if not exists Avioes(
	IdAviao INT UNSIGNED AUTO_INCREMENT,
    NomeAviao varchar(100) not null,
    Transportadora varchar(100) not null,
	CONSTRAINT pk_Avioes_IdAviao PRIMARY KEY(IdAviao)
)ENGINE=InnoDB;

Create table if not exists Voos(
	IdVoo INT UNSIGNED AUTO_INCREMENT,
    DataHoraPartida datetime not null,
    DataHoraChegada datetime not null,
    IdAeroportoOrigem int UNSIGNED not null,
	IdAeroportoDestino int UNSIGNED not null,
    IdAviao int UNSIGNED not null,
	CONSTRAINT pk_Voos_IdVoo PRIMARY KEY(IdVoo),
	CONSTRAINT fk_Voos_IdAeroportoOrigem FOREIGN KEY(IdAeroportoOrigem) REFERENCES Aeroportos(IdAeroporto),
	CONSTRAINT fk_Voos_IdAeroportoDestino FOREIGN KEY(IdAeroportoDestino) REFERENCES Aeroportos(IdAeroporto),
    CONSTRAINT fk_Voos_IdAviao FOREIGN KEY(IdAviao) REFERENCES Avioes(IdAviao)
)ENGINE=InnoDB;


Create table if not exists Escalas(
	IdEscala INT UNSIGNED AUTO_INCREMENT,
    DataHoraPartida datetime not null,
    DataHoraChegada datetime not null,
    IdAeroportoOrigem int UNSIGNED not null,
	IdAeroportoDestino int UNSIGNED not null,
    IdAviao int UNSIGNED not null,
    IdVoo int UNSIGNED not null,
	CONSTRAINT pk_Escalas_IdVoo PRIMARY KEY(IdEscala),
	CONSTRAINT fk_Escalas_IdAeroportoOrigem FOREIGN KEY(IdAeroportoOrigem) REFERENCES Aeroportos(IdAeroporto),
	CONSTRAINT fk_Escalas_IdAeroportoDestino FOREIGN KEY(IdAeroportoDestino) REFERENCES Aeroportos(IdAeroporto),
    CONSTRAINT fk_Escalas_IdAviao FOREIGN KEY(IdAviao) REFERENCES Avioes(IdAviao),
    CONSTRAINT fk_Escalas_IdVoo FOREIGN KEY(IdVoo) REFERENCES Voos(IdVoo)
)ENGINE=InnoDB;


Create table if not exists ComprasVoo(
IdCompraVoo INT UNSIGNED AUTO_INCREMENT,
IdCliente int UNSIGNED not null,
IdVoo int UNSIGNED not null,
Preco int not null,
DataCompra datetime not null,
CONSTRAINT pk_ComprasVoo_IdCompraVoo PRIMARY KEY(IdCompraVoo),
CONSTRAINT fk_ComprasVoo_IdCliente FOREIGN KEY(IdCliente) REFERENCES Utilizadores(IdUtilizador),
CONSTRAINT fk_ComprasVoo_IdVoo FOREIGN KEY(IdVoo) REFERENCES Voos(IdVoo)
)ENGINE=InnoDB;

INSERT INTO Utilizadores
VALUES (null, 'Admin Master', '2000-01-01', 'adminmaster@localhost.com', '912345678', 'adminmaster', 'adminmaster', 'administrador');
