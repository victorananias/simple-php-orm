CREATE DATABASE meubanco;
USE meubanco;

CREATE TABLE tarefas(
    id int not null primary key auto_increment,
    descricao text,
    completa boolean
);

INSERT INTO tarefas(descricao, completa) VALUES('Revisar php básico.', false);
INSERT INTO tarefas(descricao, completa) VALUES('Revisar javascript básico.', false);
INSERT INTO tarefas(descricao, completa) VALUES('Estudar Angular.', false);