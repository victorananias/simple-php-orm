CREATE DATABASE meubanco;
USE meubanco;

CREATE TABLE tarefas(
    id int not null primary key auto_increment,
    descricao text,
    completa boolean
);

CREATE TABLE usuarios(
    id int not null primary key auto_increment,
    nome varchar(250) not null
);


INSERT INTO tarefas(descricao, completa) VALUES('Revisar php básico.', true);
INSERT INTO tarefas(descricao, completa) VALUES('Revisar javascript básico.', false);
INSERT INTO tarefas(descricao, completa) VALUES('Estudar Angular.', false);

INSERT INTO usuarios(nome) VALUES('Victor');