DROP DATABASE IF EXISTS banco_teste;

CREATE DATABASE banco_teste;

USE banco_teste;

CREATE TABLE produtos(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    nome VARCHAR(250) NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    segmento_id INT NOT NULL
);

CREATE TABLE segmentos(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(250) NOT NULL,
    descricao TEXT
);

ALTER TABLE produtos ADD FOREIGN KEY(segmento_id) REFERENCES segmentos(id);

INSERT INTO segmentos VALUES(NULL, "Saúde", "Produtos utilizado para Saúde."), 
(NULL, "Cosméticos", "Produtos utilizado para Cosméticos."), 
(NULL, "Alimentício", "Produtos utilizado para Alimentício.");