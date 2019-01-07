-- CREATE PROCEDURE sp_sprodutos AS SELECT * FROM TblProduto; --
-- CREATE PROCEDURE sp_isegmentos (
--     @NmSegmento VARCHAR(250),
--     @Descricao TEXT
-- ) AS INSERT INTO TblSegmento VALUES(@NmSegmento, @Descricao);

DROP DATABASE IF EXISTS banco_teste;

CREATE DATABASE banco_teste;

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

ALTER TABLE TblProduto ADD FOREIGN KEY (SegmentoID) REFERENCES TblProduto(ProdutoID);

exec sp_isegmentos 'Saúde', 'Produtos utilizado para Saúde.';
exec sp_isegmentos 'Cosméticos', 'Produtos utilizado para Cosméticos.'; 
exec sp_isegmentos 'Alimentício', 'Produtos utilizado para Alimentício.';