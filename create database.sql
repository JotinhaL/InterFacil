CREATE DATABASE intercambio;

USE intercambio;

CREATE TABLE nivel_ensino(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE status_ensino(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE tipo_usuario(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE usuario(
    id INT NOT NULL AUTO_INCREMENT,
    id_tipo_usuario INT NOT NULL,
    nome VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    dataNascimento DATETIME NOT NULL,
    nivelEnsino INT NOT NULL,
    statusEnsino INT NOT NULL,
    experiencia VARCHAR(255) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (id_tipo_usuario) REFERENCES tipo_usuario (id),
    FOREIGN KEY (nivelEnsino) REFERENCES nivel_ensino (id),
    FOREIGN KEY (statusEnsino) REFERENCES status_ensino (id)
);

CREATE TABLE vaga(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    nivelEnsino INT NOT NULL,
    statusEnsino INT NOT NULL,
    
    PRIMARY KEY (id),
    FOREIGN KEY (nivelEnsino) REFERENCES nivel_ensino (id),
    FOREIGN KEY (statusEnsino) REFERENCES status_ensino (id)
);

CREATE TABLE idioma(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE fluencia(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE idiomas_usuario(
    id INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_idioma INT NOT NULL,
    id_fluencia INT NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id),
    FOREIGN KEY (id_idioma) REFERENCES idioma (id),
    FOREIGN KEY (id_fluencia) REFERENCES fluencia (id)
);

CREATE TABLE idiomas_vaga(
    id INT NOT NULL AUTO_INCREMENT,
    id_vaga INT NOT NULL,
    id_idioma INT NOT NULL,
    id_fluencia INT NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (id_vaga) REFERENCES vaga (id),
    FOREIGN KEY (id_idioma) REFERENCES idioma (id),
    FOREIGN KEY (id_fluencia) REFERENCES fluencia (id)
);

CREATE TABLE usuario_vaga(
    id INT NOT NULL AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    id_vaga INT NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES usuario (id),
    FOREIGN KEY (id_vaga) REFERENCES vaga (id)
)