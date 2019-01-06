DROP DATABASE IF EXISTS banco_teste;

CREATE DATABASE banco_teste;

USE banco_teste;

CREATE TABLE TblProduto(
    ProdutoID INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    NmProduto VARCHAR(250),
    DtCadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    SegmentoID  INT
);

CREATE TABLE TblSegmento(
    SegmentoID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    NmSegmento VARCHAR(250),
    Descricao TEXT
);

INSERT INTO TblSegmento VALUES(NULL, "Saúde", "Produtos utilizado para Saúde."), 
(NULL, "Cosméticos", "Produtos utilizado para Cosméticos."), 
(NULL, "Alimentício", "Produtos utilizado para Alimentício.");