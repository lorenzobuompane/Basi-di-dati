/* 1A
Per ogni guida che non ha mai effettuato visite guidate a gruppi di lingua francesce, visualizzare il nome e il cognome e, per ciascuna data, il numero totale di visite guidate effettuate e la loro durata complessiva.
*/

SELECT G.Nome, G.Cognome, VGE.Data, COUNT(*) AS TOT_VISITE, SUM(TP.Durata) AS DUR_TOT
FROM GUIDA G, VISITA-GUIDATA-EFFETTUATA VGE, TIPO-VISITA TP
WHERE VGE.CodGuida NOT IN (
				SELECT VGE1.CodGuida
				FROM VISITA-GUIDATA-EFFETTUATA VGE1, GRUPPO GR
				WHERE VGE1.CodGR=GR.CodGR
				AND GR.Lingua='Francese'
				)
AND TP.CodTipoVisita=VGE.CodTipoVisita
AND G.CodGuida=VGE.CodGuida
GROUP BY G.CodGuida, G.Nome, G.Cognome, VGE.Data;

/* 1B
Tra i monumenti per cui sono state effettuate almeno 10 visite guidate, visualizzare il monumento che `e stato visitato complessivamente dal maggior numero di persone.
*/

SELECT TOP-MONUMENTI.Monumento
FROM (	SELECT TP.Monumento, SUM(GR.NumeroPartecipanti) AS TOT_PART
		FROM TIPO-VISITA TP, VISITA-GUIDATA-EFFETTUATA VGE, GRUPPO GR
		WHERE TP.CodTipoVisita=VGE.CodTipoVisita
		AND VGE.CodGR=GR.CodGR
		GROUP BY TP.Monumento
		HAVING COUNT(*)>=10
		) AS TOP-MONUMENTI
GROUP BY TOP-MONUMENTI.Monumento
HAVING TOP-MONUMENTI.TOT_PART=(	SELECT MAX(TOP-MONUMENTI.TOT_PART)
								FROM TOP-MONUMENTI);

/* 2A
Per ogni dispositivo che `e stato utilizzato in almeno 10 esperimenti, visualizzare il nome del dispositivo, il nome del laboratorio presso cui il dispositivo `e collocato e, per ciascun studente che ha utilizzato il dispositivo, il numero di esperimenti eseguiti dallo studente con quel dispositivo.
*/

SELECT D.NomeDisp, D.CodLab, E.Matricola, COUNT(E.Data) AS NUM-ESPERIMENTI
FROM DISPOSITIVO D, ESPERIMENTO E, LABORATORIO L, STUDENTE S
WHERE D.CodiceDisp IN (
				SELECT E1.CodiceDisp
				FROM ESPERIMENTO E1
				GROUP BY E1.CodiceDisp
				HAVING COUNT(*)>=10
				)
AND D.CodiceDisp=E.CodiceDisp
AND D.CodLab=L.CodLab
AND S.Matricola=E.Matricola
GROUP BY E.Matricola, D.CodiceDisp, D.NomeDisp, D.CodLab;

/* 2B
Considerando i laboratori presso cui sono stati eseguiti esclusivamente esperimenti svolti da studenti iscritti al corso di laurea di ’Ingegneria Informatica’, visualizzare, per ogni laboratorio, codice e nome del laboratorio e la data di ciascun esperimento di categoria ’Elettronica’ eﬀettuato durante il mese di Giugno 2019.
*/

SELECT L.CodLab, L.NomeLab, E.Data
FROM LABORATORIO L, ESPERIMENTO E, DISPOSITIVO D
WHERE L.CodLab NOT IN (
			SELECT D1.CodLab
			FROM ESPERIMENTO E1, STUDENTE S, DISPOSITIVO D1
			WHERE E1.Matricola=S.Matricola
			AND S.CorsoDiLaurea<>'Ingegneria Informatica'
			AND D1.CodiceDisp=E1.CodiceDisp
			)
AND E.CodiceDisp=D.CodiceDisp
AND L.CodLab=D.CodLab
AND E.Categoria='Elettronica'
AND E.Data<TO_DATE('01/07/2019', 'DD/MM/YYYY')
AND E.Data>TO_DATE('31/05/2019', 'DD/MM/YYYY');

/* 3A
Per ciascun campo estivo presso cui sono iscritti almeno 15 ragazzi per svolgere attività aﬀerenti ad almeno 3 diverse categorie, visualizzare il nome del campo, la citt`a presso cui il campo si svolge e per ciascuna attivit`a svolta nel campo il numero di ragazzi che si sono iscritti.
*/

SELECT C.NomeCampo, C.Città, I.CodAttività, COUNT(*) AS NUM_ISCRITTI
FROM CAMPO-ESTIVO C, ISCRIZIONE-PER-ATTIVITà-IN-CAMPO-ESTIVO I
WHERE C.CodCampo IN (
			SELECT I1.CodCampo
			FROM ISCRIZIONE-PER-ATTIVITà-IN-CAMPO-ESTIVO I1, ATTIVITà A1
			WHERE A1.CodAttività=I1.CodAttività
			GROUP BY I1.CodCampo
			HAVING COUNT(A1.Categoria)>=3
			AND COUNT(*)>=15
			)
AND I.CodCampo=C.CodCampo
GROUP BY C.CodCampo, C.NomeCampo, C.Città, I.CodAttività;

/* 3B
Per ogni ragazzo nato prima del 2005 ed iscritto ad attività presso almeno 3 campi estivi, visualizzare nome e cognome del ragazzo e il nome di ciascun campo in cui il ragazzo è iscritto a tutte le diverse attività organizzate dal campo.
*/

SELECT R.Nome, R.Cognome, I.CodCampo
FROM RAGAZZO R, ISCRIZIONE-PER-ATTIVITà-IN-CAMPO-ESTIVO I, (
										SELECT I2.CodCampo AS CodCampo, COUNT(I2.CodAttività) AS NUM_ATT
										FROM ISCRIZIONE-PER-ATTIVITà-IN-CAMPO-ESTIVO I2
										GROUP BY I2.CodCampo
										) AS ATTIVITà-PER-CAMPO AC
WHERE R.CodFiscale IN (
			SELECT I1.CodFiscale
			FROM ISCRIZIONE-PER-ATTIVITà-IN-CAMPO-ESTIVO I1
			GROUP BY I1.CodFiscale
			HAVING COUNT(I1.CodCampo)>=3
			)
AND R.CodFiscale=I.CodFiscale
AND I.CodCampo=AC.CodCampo
AND R.DataNascita<TO_DATE('01/01/2005', 'DD/MM/YYYY')
GROUP BY R.CodFiscale, R.Nome, R.Cognome, I.CodCampo
HAVING COUNT(I.CodAttività)=NUM_ATT;











