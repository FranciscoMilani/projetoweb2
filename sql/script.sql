create table respondente (
    id serial not null,
    login varchar(30) not null unique,
    senha varchar(255) not null,
    nome varchar(255) not null,
    telefone varchar(255) not null,
    email varchar(255) not null,
	constraint pk_respondente primary key(id)
);


create table elaborador (
    id serial not null,
    login varchar(30) not null unique,
    senha varchar(255) not null,
    nome varchar(255) not null,
    instituicao varchar(255) not null,
    email varchar(255) not null,
    isAdmin boolean not null,
	constraint pk_elaborador primary key(id)
);


insert into elaborador(login, senha, nome, instituicao, email, isAdmin) values ('admin','202cb962ac59075b964b07152d234b70','Administrador', 'UCS', 'adm@ucs.br', True);
insert into elaborador values (DEFAULT, 'elab', '202cb962ac59075b964b07152d234b70', 'Professor Elaborador', 'UCS', 'professorelab@ucs.br', false);
insert into respondente(login, senha, nome, telefone, email) values ('user','202cb962ac59075b964b07152d234b70','Usuario Respondente', '987654321', 'user@ucs.br');


create table questionario (
    id serial not null,
    nome varchar(255) not null,
    descricao varchar(5000) not null,
    notaAprovacao DECIMAL not null,
    dataCriacao DATE NOT NULL,
    elaboradorId bigint NOT NULL,
	constraint pk_questionario primary key(id),
    foreign key (elaboradorId) references elaborador(id) on delete cascade
);


create table questao (
    id serial not null,
    descricao varchar(5000) not null,
    isDiscursiva boolean not null,
    isObjetiva boolean not null,
    isMultiplaEscolha boolean not null,
	CONSTRAINT pk_questao PRIMARY KEY(id),
	CONSTRAINT CheckOnlyOneColumnIsNull
	CHECK 
	(
		( CASE WHEN isDiscursiva = false THEN 0 ELSE 1 END
		+ CASE WHEN isObjetiva = false THEN 0 ELSE 1 END
		+ CASE WHEN isMultiplaEscolha = false THEN 0 ELSE 1 END
		) = 1
	)
);


create table questionarioquestao (
    pontos DECIMAL not null,
    ordem INTEGER not null,
    questionarioId bigint NOT NULL,
    questaoId bigint NOT NULL,
	UNIQUE (ordem, questionarioId),
	UNIQUE (questaoId, questionarioId),
	PRIMARY KEY (questionarioId, questaoId),
	CONSTRAINT fk_questionario FOREIGN KEY (questionarioId) REFERENCES questionario(id) ON DELETE CASCADE,
	CONSTRAINT fk_questao FOREIGN KEY (questaoId) REFERENCES questao(id) ON DELETE CASCADE
);


CREATE TABLE alternativa (
    id SERIAL NOT NULL,
    descricao VARCHAR(1000) NOT NULL,
    isCorreta BOOLEAN NOT NULL,
	questaoId INTEGER NOT NULL,
    PRIMARY KEY (id),
	CONSTRAINT fk_questao FOREIGN KEY (questaoId) REFERENCES questao(id) ON DELETE CASCADE
);


CREATE TABLE oferta (
	id SERIAL NOT NULL,
    data DATE NOT NULL,
    questionarioId INTEGER NOT NULL,
    respondenteId INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (questionarioId) REFERENCES questionario(id) ON DELETE CASCADE,
    FOREIGN KEY (respondenteId) REFERENCES respondente(id) ON DELETE CASCADE
);


CREATE TABLE submissao (
    id SERIAL NOT NULL,
    nomeOcasiao VARCHAR(255),
    descricao VARCHAR(255),
    data DATE NOT NULL DEFAULT CURRENT_DATE,
    ofertaId INTEGER NOT NULL,
	respondenteId INTEGER NOT NULL,
	PRIMARY KEY (id),
    FOREIGN KEY (ofertaId) REFERENCES oferta(id) ON DELETE CASCADE,
	FOREIGN KEY (respondenteId) REFERENCES respondente(id) ON DELETE CASCADE
);


CREATE TABLE resposta (
    id SERIAL NOT NULL,
    texto VARCHAR(5000),
    nota DECIMAL,
    observacao VARCHAR(1000),
    questaoId INTEGER NOT NULL,
    submissaoId INTEGER NOT NULL,
	PRIMARY KEY(id),
    FOREIGN KEY (questaoId) REFERENCES questao(id) ON DELETE CASCADE,
    FOREIGN KEY (submissaoId) REFERENCES submissao(id) ON DELETE CASCADE
);


CREATE TABLE respostaalternativa (
    id SERIAL NOT NULL,
    respostaId INTEGER NOT NULL,
    alternativaId INTEGER NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (respostaId) REFERENCES resposta(id) ON DELETE CASCADE,
    FOREIGN KEY (alternativaId) REFERENCES alternativa(id) ON DELETE CASCADE
);