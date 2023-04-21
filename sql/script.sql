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

alter table elaborador 
add constraint pk_elaborador
primary key(id);

-- insere dados do administrador
-- senha = '123' em md5
insert into elaborador(login, senha, nome, instituicao, email, isAdmin) values ('admin','202cb962ac59075b964b07152d234b70','Administrador', 'UCS', 'adm@ucs.br', True);

create table questionario (
    id serial not null,
    nome varchar(255) not null,
    descricao varchar(255) not null,
    notaAprovacao DECIMAL not null,
    dataCriacao DATE NOT NULl,
    elaboradorId bigint NOT NULL
);

alter table questionario 
add constraint pk_questionario
primary key(id);


create table questao (
    id serial not null,
    descricao varchar(255) not null,
    isDiscursiva boolean not null,
    isObjetiva boolean not null,
    isMultiplaEscolha boolean not null,
);

alter table questao 
add constraint pk_questao
primary key(id);


create table questionarioquestao (
    id serial not null,
    pontos DECIMAL not null,
    ordem INTEGER not null,
    questionarioId bigint NOT NULL,
    questaoId bigint NOT NULL,
);
alter table questionarioquestao 
add constraint pk_questao
primary key(id);
add constraint fk_questionario
FOREIGN KEY(questionarioId)
add constraint fk_questao
FOREIGN KEY(questaoId)


-- alterar tabela usuario para respondente no banco
-- e no php criar a classe usuário com todos gets e sets, para as outras estenderem a ela