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

insert into respondente(login, senha, nome, telefone, email) values ('user','202cb962ac59075b964b07152d234b70','Usuario Respondente', '987654321', 'user@ucs.br');

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
add constraint pk_questao primary key(id),
ADD CONSTRAINT CheckOnlyOneColumnIsNull
CHECK 
(
    ( CASE WHEN isDiscursiva = false THEN 0 ELSE 1 END
    + CASE WHEN isObjetiva = false THEN 0 ELSE 1 END
    + CASE WHEN isMultiplaEscolha = false THEN 0 ELSE 1 END
    ) = 1
);


create table questionarioquestao (
    pontos DECIMAL not null,
    ordem INTEGER not null,
    questionarioId bigint NOT NULL,
    questaoId bigint NOT NULL
);

ALTER TABLE questionarioquestao
DROP CONSTRAINT IF EXISTS questionarioquestao_pkey,
ADD UNIQUE (ordem, questionarioId),
ADD UNIQUE (questaoId, questionarioId),
ADD PRIMARY KEY (questionarioId, questaoId);
ADD CONSTRAINT fk_questionario FOREIGN KEY (questionarioId) REFERENCES questionario(id),
ADD CONSTRAINT fk_questao FOREIGN KEY (questaoId) REFERENCES questao(id);


CREATE TABLE alternativa (
    id SERIAL NOT NULL,
    descricao VARCHAR(1000) NOT NULL,
    isCorreta BOOLEAN NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE alternativa
ADD questaoId INTEGER NOT NULL,
ADD CONSTRAINT fk_questao FOREIGN KEY (questaoId) REFERENCES questao(id);


CREATE TABLE oferta (
	id SERIAL NOT NULL,
    data DATE NOT NULL,
    questionarioId INTEGER NOT NULL,
    respondenteId INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (questionarioId) REFERENCES questionario(id),
    FOREIGN KEY (respondenteId) REFERENCES respondente(id)
);

CREATE TABLE submissao (
    id SERIAL NOT NULL,
    nomeOcasiao VARCHAR(255),
    descricao VARCHAR(255),
    data DATE NOT NULL,
    ofertaId INTEGER NOT NULL,
	PRIMARY KEY (id),
    FOREIGN KEY (ofertaId) REFERENCES oferta(id)
);

CREATE TABLE resposta (
    id SERIAL NOT NULL,
    texto VARCHAR(5000),
    nota DECIMAL NOT NULL,
    observacao VARCHAR(1000),
    questaoId INTEGER NOT NULL,
    alternativaId INTEGER,
    submissaoId INTEGER NOT NULL,
	PRIMARY KEY(id),
    FOREIGN KEY (questaoId) REFERENCES questao(id),
    FOREIGN KEY (alternativaId) REFERENCES alternativa(id),
    FOREIGN KEY (submissaoId) REFERENCES submissao(id),
    CHECK ((texto IS NOT NULL) OR (alternativaId IS NOT NULL))
);