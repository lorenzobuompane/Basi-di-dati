<html>
<link rel="stylesheet" href="https://www.w3schools.com/css/css_colors.asp"> 
<body>


<?php

	//Verifica dati mancanti
	if (!isset($_REQUEST["cod_ciclista"]) || trim($_REQUEST["cod_ciclista"]) == "" || !is_numeric($_REQUEST["cod_ciclista"]) || $_REQUEST["cod_ciclista"]<0 ){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Codice ciclista errato o mancante.
				</th>
				</tr>
				</table>";
		exit;
		
	}
	
	if (!isset($_REQUEST["cod_squadra"]) || trim($_REQUEST["cod_squadra"]) == "" || !is_numeric($_REQUEST["cod_squadra"]) || $_REQUEST["cod_squadra"]<0 ){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Codice squadra errato o mancante.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	if (!isset($_REQUEST["anno_ciclista"]) || trim($_REQUEST["anno_ciclista"]) == "" || !is_numeric($_REQUEST["anno_ciclista"]) || $_REQUEST["anno_ciclista"]<0 ){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Anno di nascita ciclista non corretto o mancante.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	if (!isset($_REQUEST["nome_ciclista"]) || trim($_REQUEST["nome_ciclista"]) == ""){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Nome ciclista non corretto o mancante.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	if (!isset($_REQUEST["cognome_ciclista"]) || trim($_REQUEST["cognome_ciclista"]) == ""){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Cognome ciclista non corretto o mancante.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	if (!isset($_REQUEST["nazione_ciclista"]) || trim($_REQUEST["nazione_ciclista"]) == ""){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Nazionalita' non corretto o mancante.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	
	//Copia in variabili
	$cod_ciclista = $_REQUEST["cod_ciclista"];
	$nome_ciclista = $_REQUEST["nome_ciclista"];
	$cognome_ciclista = $_REQUEST["cognome_ciclista"];
	$nazione_ciclista = $_REQUEST["nazione_ciclista"];
	$cod_squadra = $_REQUEST["cod_squadra"];
	$anno_ciclista = $_REQUEST["anno_ciclista"];
	
	//Connessione a MySQL
	$con = mysqli_connect('localhost','root','','campionato');

	if (mysqli_connect_errno()) {
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	} 
	
	//
	$cod_ciclista = utf8_decode(mysqli_real_escape_string($con, $cod_ciclista)); 
	$nome_ciclista = utf8_decode(mysqli_real_escape_string($con, $nome_ciclista)); 
	$cognome_ciclista = utf8_decode(mysqli_real_escape_string($con, $cognome_ciclista)); 
	$nazione_ciclista = utf8_decode(mysqli_real_escape_string($con, $nazione_ciclista)); 
	$cod_squadra = utf8_decode(mysqli_real_escape_string($con, $cod_squadra)); 
	$anno_ciclista = utf8_decode(mysqli_real_escape_string($con, $anno_ciclista)); 

	//Controllo esistenza squadra
	$ver_squadra = "	SELECT CodS 
						FROM SQUADRA 
						WHERE CodS='$cod_squadra'";
	
	$result = mysqli_query ( $con, $ver_squadra );
	if (!$result){
		die ( 'Query error: ' . mysqli_error ( $con ) );
	}
	$ris=mysqli_fetch_array($result);
	if ($ris==NULL) {
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Codice squadra non presente nel DB.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	//Controllo NON esistenza ciclista
	$ver_ciclista = "SELECT CodC 
						FROM CICLISTA 
						WHERE CodC='$cod_ciclista'";
	
	$result = mysqli_query ( $con, $ver_ciclista );
	if (!$result){
		die ( 'Query error: ' . mysqli_error ( $con ) );
	}
	$ris=mysqli_fetch_array($result);
	if ($ris!=NULL) {
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Codice ciclista già presente nel DB.
				</th>
				</tr>
				</table>";
		exit;
	}

	//INSERIMENTO
	$start = mysqli_query($con, "START TRANSACTION");
	$query = " INSERT INTO CICLISTA (CodC, Nome, Cognome, Nazionalita, CodS, AnnoNascita)
VALUES
	('$cod_ciclista', '$nome_ciclista', '$cognome_ciclista', '$nazione_ciclista', '$cod_squadra', '$anno_ciclista')";
	
	$result = mysqli_query ( $con, $query );
	$commit = mysqli_query($con, "COMMIT");
	if (!$result){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Errore nell'inserimento.
				</th>
				</tr>
				</table>";
		exit;
	} 
	else {
		echo " 	<table>
					<tr style = \"background-color: green; color:white\">
					<th>
						Congratulazione!
					<br>
						Inserimento avvenuto con successo.
					</th>
					</tr>
					</table>";
			exit;
	}
	

?>
</body>
</html>