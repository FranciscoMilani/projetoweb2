create table respondente (
    id serial not null,
    login varchar(30) not null unique,
    senha varchar(255) not null,
    nome varchar(255) not null,
    telefone varchar(255) not null,
    email varchar(255) not null
);

alter table respondente 
add constraint pk_respondente
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
    descricao varchar(5000) not null,
    notaAprovacao DECIMAL not null,
    dataCriacao DATE NOT NULl,
    elaboradorId bigint NOT NULL
);

alter table questionario 
add constraint pk_questionario primary key(id);


create table questao (
    id serial not null,
    descricao varchar(5000) not null,
    isDiscursiva boolean not null,
    isObjetiva boolean not null,
    isMultiplaEscolha boolean not null
);

alter table questao 
add constraint pk_questao primary key(id);


create table questionarioquestao (
    pontos DECIMAL not null,
    ordem INTEGER not null,
    questionarioId bigint NOT NULL,
    questaoId bigint NOT NULL
);

ALTER TABLE questionarioquestao
ADD PRIMARY KEY (questionarioId, questaoId),
ADD CONSTRAINT fk_questionario FOREIGN KEY (questionarioId) REFERENCES questionario(id),
ADD CONSTRAINT fk_questao FOREIGN KEY (questaoId) REFERENCES questao(id);


CREATE TABLE alternativa (
    id SERIAL NOT NULL,
    descricao VARCHAR(1000) NOT NULL,
    isCorreta BOOLEAN NOT NULL,
    PRIMARY KEY (id)
);

-- analisar melhor se esta tabela esta correta
CREATE TABLE resposta (
    id SERIAL NOT NULL,
    texto VARCHAR(5000), -- RESPOSTA PODE SER NULL
    nota DECIMAL NOT NULL, -- nota
    questaoId BIGINT NOT NULL,
    alternativaId BIGINT, --  ALTERNATIVA PODE SER NULL
	PRIMARY KEY(id),
    FOREIGN KEY (questaoId) REFERENCES questao(id),
    FOREIGN KEY (alternativaId) REFERENCES alternativa(id),
    CHECK ((texto IS NOT NULL) OR (alternativaId IS NOT NULL))
);