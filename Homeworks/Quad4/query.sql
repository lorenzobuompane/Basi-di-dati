--CodC = 1, CodT = 1
SELECT Nome, Cognome, NomeS, CittaPartenza, CittaArrivo, Dislivello, GradoDifficolta, Lunghezza, T.Edizione, Posizione
FROM CICLISTA C, TAPPA T, CLASSIFICA_INDIVIDUALE CI, SQUADRA S
WHERE C.CodC=1
AND T.CodT=1
AND CI.CodC=C.CodC
AND CI.CodT=T.CodT
AND CI.Edizione=T.Edizione
AND C.CodS=S.CodS
ORDER BY T.Edizione

START TRANSACTION;
INSERT INTO CICLISTA (CodC, Nome, Cognome, Nazionalita, CodS, AnnoNascita)
VALUES
  (10, "John", "White", "USA", 3, 1972);
INSERT INTO CLASSIFICA_INDIVIDUALE (CodC, CodT, Edizione, Posizione)
VALUES
  (10, 1, 2, 3);
UPDATE CLASSIFICA_INDIVIDUALE 
SET Posizione=Posizione+1
WHERE CodC<>10
AND CodT=1
AND Edizione=2
AND Posizione>=3;
COMMIT;