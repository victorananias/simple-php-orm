CREATE DATABASE banco_teste;
USE banco_teste;

CREATE TABLE TblProduto(
    ProdutoID int not null auto_increment, 
    NmProduto varchar(250),
    DtCadastro datetime default CURRENT_TIMESTAMP,
    SegmentoID  int,
    primary key(ProdutoID)
);

CREATE TABLE TblSegmento(
    SegmentoID int not null auto_increment,
    NmSegmento varchar(250),
    Descricao text,
    primary key(SegmentoID)
);

INSERT INTO TblSegmento(NmSegmento, Descricao) VALUES( "Saúde", "Produtos utilizado para Saúde. "), 
( "Cosméticos", "Produtos utilizado para Cosméticos. "), 
( "Alimentício", "Produtos utilizado para Alimentício. ");