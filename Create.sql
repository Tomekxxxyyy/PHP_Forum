CREATE DATABASE forum DEFAULT CHARACTER SET utf8;

CREATE TABLE forum_tematy(
    id_tematu INT PRIMARY KEY AUTO_INCREMENT,
    nazwa_tematu VARCHAR(150),
    data_utworzenia_tematu DATETIME,
    autor_tematu VARCHAR(150)
);

CREATE TABLE forum_posty(
    id_postu INT PRIMARY KEY AUTO_INCREMENT,
    id_tematu INT NOT NULL,
    tresc_postu TEXT,
    data_utworzenia_postu DATETIME,
    autor_postu VARCHAR(150)
);
