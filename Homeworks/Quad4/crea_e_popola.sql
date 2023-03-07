------ CREATE ------

DROP DATABASE IF EXISTS CAMPIONATO;
CREATE DATABASE IF NOT EXISTS CAMPIONATO;
USE CAMPIONATO;

CREATE TABLE SQUADRA (
CodS INT NOT NULL,
NomeS VARCHAR(50) NOT NULL,
AnnoFondazione INT NOT NULL CHECK(AnnoFondazione >= 1900 AND AnnoFondazione <= 2000),
SedeLegale VARCHAR(50),
PRIMARY KEY(CodS)
);

CREATE TABLE CICLISTA (
CodC INT NOT NULL,
Nome VARCHAR(50) NOT NULL,
Cognome VARCHAR(50) NOT NULL,
Nazionalita VARCHAR(50) NOT NULL,
CodS INT NOT NULL,
AnnoNascita INT NOT NULL CHECK(AnnoNascita >= 1900 AND AnnoNascita <= 2000),
PRIMARY KEY(CodC),
FOREIGN KEY (CodS) REFERENCES SQUADRA(CodS) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE TAPPA (
Edizione INT NOT NULL CHECK(Edizione >= 0) ,
CodT INT NOT NULL CHECK(CodT >= 0) ,
CittaPartenza VARCHAR(50) NOT NULL,
CittaArrivo VARCHAR(50) NOT NULL,
Lunghezza INT NOT NULL,
Dislivello INT NOT NULL,
GradoDifficolta SMALLINT NOT NULL CHECK(GradoDifficolta >= 0 AND GradoDifficolta <= 10),
PRIMARY KEY (Edizione, CodT)
);

CREATE TABLE CLASSIFICA_INDIVIDUALE (
CodC INT NOT NULL,
CodT INT NOT NULL CHECK(CodT >= 0),
Edizione INT NOT NULL CHECK(Edizione >= 0),
Posizione SMALLINT CHECK(Posizione >= 1),
PRIMARY KEY(CodC, CodT, Edizione),
FOREIGN KEY (CodC) REFERENCES CICLISTA(CodC) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Edizione, CodT) REFERENCES TAPPA(Edizione, CodT) ON DELETE CASCADE ON UPDATE CASCADE
);

------ INSERT ------

INSERT INTO SQUADRA (CodS, NomeS, AnnoFondazione, SedeLegale)
VALUES 
  (1, 'Red Team', 1972, 'San Jose'),
  (2, 'Black Team', 1945, 'Roma'),
  (3, 'Yellow Team', 2000, 'Pechino'),
  (4, 'Green Team', 1943, 'Lima'),
  (5, 'Blue Team', 1967, 'New York');
  
INSERT INTO CICLISTA (CodC, Nome, Cognome, Nazionalita, CodS, AnnoNascita)
VALUES
  (1, 'Mi', 'Yang', 'Cina', 3, 1965),
  (2, 'Robert', 'Lhieber', 'Germania', 4, 1980),
  (3, 'Giacomo', 'Delpo', 'Italia', 1, 1975),
  (4, 'Gustav', 'Kley', 'Olanda', 2, 2000),
  (5, 'Mirko', 'Salem', 'Polonia', 5, 1956);

INSERT INTO TAPPA (Edizione, CodT, CittaPartenza, CittaArrivo, Lunghezza, Dislivello,  GradoDifficolta)
VALUES
  (1, 1, 'Bologna', 'Fucecchio', 205000, 250, 3),
  (1, 2, 'Vinci', 'Ortobello', 220000, 325, 2),
  (2, 1, 'Frascati', 'Terracine', 140000, 1500, 5),
  (2, 2, 'Tortoreto Lido', 'Pesato', 239000, 400, 1),
  (3, 1, 'Pinerolo', 'Ceresole Reale', 195000, 245, 2);
  
INSERT INTO CLASSIFICA_INDIVIDUALE (CodC, CodT, Edizione, Posizione)
VALUES
  (1, 1, 1, 1),
  (2, 1, 1, 3),
  (3, 1, 1, 2),
  (4, 1, 1, 4),
  (5, 1, 1, 5),
  (1, 2, 1, 2),
  (2, 2, 1, 3),
  (3, 2, 1, 4),
  (4, 2, 1, 1),
  (5, 2, 1, 5),
  (1, 1, 2, 2),
  (2, 1, 2, 3),
  (3, 1, 2, 4),
  (4, 1, 2, 1),
  (5, 1, 2, 5),
  (1, 2, 2, 2),
  (2, 2, 2, 3),
  (3, 2, 2, 4),
  (4, 2, 2, 1),
  (5, 2, 2, 5),
  (1, 1, 3, 1),
  (2, 1, 3, 2),
  (3, 1, 3, 3),
  (4, 1, 3, 4),
  (5, 1, 3, 5);


