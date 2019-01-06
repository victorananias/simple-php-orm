DROP DATABASE IF EXISTS banco_teste;

CREATE DATABASE banco_teste;

USE banco_teste;

CREATE TABLE TblProduto(
    ProdutoID INT NOT NULL PRIMARY KEY IDENTITY(1, 1), 
    NmProduto VARCHAR(250),
    DtCadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    SegmentoID  INT
);

CREATE TABLE TblSegmento(
    SegmentoID INT NOT NULL PRIMARY KEY IDENTITY(1, 1),
    NmSegmento VARCHAR(250),
    Descricao TEXT
);

INSERT INTO TblSegmento VALUES('Saúde', 'Produtos utilizado para Saúde.'), 
('Cosméticos', 'Produtos utilizado para Cosméticos.'), 
('Alimentício', 'Produtos utilizado para Alimentício.');