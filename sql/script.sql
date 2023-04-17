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
-- ver como criptografar essa senha manualmente para inserir
insert into elaborador(login, senha, nome, instituicao, email, isAdmin) values ('admin','admin','Administrador', 'UCS', 'adm@ucs.br', True);


alter table elaborador 
add constraint pk_elaborador
primary key(id);
