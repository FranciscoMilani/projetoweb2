create table usuario (
    id serial not null,
    login varchar(30) not null unique,
    senha varchar(255) not null,
    nome varchar(255) not null,
    telefone varchar(255) not null,
    email varchar(255) not null
);

alter table usuario 
add constraint pk_usuario
primary key(id);

create table elaborador (
    id serial not null,
    login varchar(30) not null unique,
    senha varchar(255) not null,
    nome varchar(255) not null,
    instituicao varchar(255) not null,
    email varchar(255) not null,
    isAdmin boolean not null
);
-- insere dados do administrador
-- senha = '123' em md5
insert into elaborador(login, senha, nome, instituicao, email, isAdmin) values ('admin','202cb962ac59075b964b07152d234b70','Administrador', 'UCS', 'adm@ucs.br', True);


alter table elaborador 
add constraint pk_elaborador
primary key(id);
