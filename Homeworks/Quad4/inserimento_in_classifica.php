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
	
	if (!isset($_REQUEST["cod_tappa"]) || trim($_REQUEST["cod_tappa"]) == "" || !is_numeric($_REQUEST["cod_tappa"]) || $_REQUEST["cod_tappa"]<0 ){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Codice tappa errato o mancante.
				</th>
				</tr>
				</table>";
		exit;	
	}
	
	if (!isset($_REQUEST["edizione"]) || trim($_REQUEST["edizione"]) == "" || !is_numeric($_REQUEST["edizione"]) || $_REQUEST["edizione"]<0 ){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Edizione errata o mancante.
				</th>
				</tr>
				</table>";
		exit;	
	}
	
	if (!isset($_REQUEST["posizione"]) || trim($_REQUEST["posizione"]) == "" || !is_numeric($_REQUEST["posizione"])){
		echo " 	<table>
				<tr style = \"background-color: red; color:white\">
				<th>
					Errore!
				<br>
					Posizione errata o mancante.
				</th>
				</tr>
				</table>";
		exit;	
	}
	
	//Copia in variabili
	$cod_ciclista = $_REQUEST["cod_ciclista"];
	$cod_tappa = $_REQUEST["cod_tappa"];
	$edizione = $_REQUEST["edizione"];
	$posizione = $_REQUEST["posizione"];
	
	//Connessione a MySQL
	$con = mysqli_connect('localhost','root','','campionato');

	if (mysqli_connect_errno()) {
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	} 
	
	//
	$cod_ciclista = utf8_decode(mysqli_real_escape_string($con, $cod_ciclista)); 
	$cod_tappa = utf8_decode(mysqli_real_escape_string($con, $cod_tappa)); 
	$edizione = utf8_decode(mysqli_real_escape_string($con, $edizione)); 
	$posizione = utf8_decode(mysqli_real_escape_string($con, $posizione)); 
	
	//Controllo esistenza ciclista
	$ver_ciclista = "SELECT CodC 
						FROM CICLISTA 
						WHERE CodC='$cod_ciclista'";
	
	$result = mysqli_query ( $con, $ver_ciclista );
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
					Codice ciclista non presente nel DB.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	//Controllo esistenza tappa e edizione
	$ver_tappa = "SELECT CodT
						FROM TAPPA 
						WHERE CodT='$cod_tappa'
						AND Edizione='$edizione'";
	
	$result = mysqli_query ( $con, $ver_tappa );
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
					Tappa $cod_tappa dell'edizione $edizione non presente nel DB.
				</th>
				</tr>
				</table>";
		exit;
	}
		
	//Controllo esistenza ciclista in classifica
	$ver_posizione = "SELECT Posizione
						FROM CLASSIFICA_INDIVIDUALE 
						WHERE CodT='$cod_tappa'
						AND Edizione='$edizione'
						AND CodC='$cod_ciclista'";
	
	$result = mysqli_query ( $con, $ver_posizione );
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
					Ciclista già presente nella classifica.
				</th>
				</tr>
				</table>";
		exit;
	}
	
	//INSERIMENTO
	$start = mysqli_query($con, "START TRANSACTION");
	$query =  "INSERT INTO CLASSIFICA_INDIVIDUALE (CodC, CodT, Edizione, Posizione)
		VALUES
		('$cod_ciclista', '$cod_tappa', '$edizione', '$posizione')"; 
	$result = mysqli_query ( $con, $query );
	$update = "UPDATE CLASSIFICA_INDIVIDUALE 
		SET Posizione=Posizione+1
		WHERE CodC<>'$cod_ciclista'
		AND CodT='$cod_tappa'
		AND Edizione='$edizione'
		AND Posizione>='$posizione'";
	$up_result = mysqli_query ( $con, $update );
	$commit = mysqli_query($con, "COMMIT");
	
	if (!$result || !$up_result){
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