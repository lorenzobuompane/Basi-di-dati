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

	//Copia in variabili
	$cod_ciclista = $_REQUEST["cod_ciclista"];
	$cod_tappa = $_REQUEST["cod_tappa"];

	//Connessione al DB
	$con = mysqli_connect('localhost','root','','campionato');

	if (mysqli_connect_errno()) {
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	} 
	
	//
	$cod_ciclista = utf8_decode(mysqli_real_escape_string($con, $cod_ciclista)); 
	$cod_tappa = utf8_decode(mysqli_real_escape_string($con, $cod_tappa)); 
	
	//Query
	$query = "	SELECT Nome as Nome, Cognome as Cognome, NomeS as NomeSquadrea, T.Edizione as Edizione, Posizione as Posizione
				FROM CICLISTA C, TAPPA T, CLASSIFICA_INDIVIDUALE CI, SQUADRA S
				WHERE C.CodC='$cod_ciclista'
				AND T.CodT='$cod_tappa'
				AND CI.CodC='$cod_ciclista'
				AND CI.CodT='$cod_tappa'
				AND CI.Edizione=T.Edizione
				AND C.CodS=S.CodS
				ORDER BY T.Edizione";
				
	$result = mysqli_query ( $con, $query );
	
	if (!$result){
		die ( 'Query error: ' . mysqli_error ( $con ) );
	}

	if (mysqli_num_rows ( $result ) > 0) {
		echo "<table border=1 cellpadding=10>";
		echo "<h1> Posizioni ciclista $cod_ciclista nella tappa $cod_tappa in varie edizioni </h1>";
		
		//Tabella
		echo "<thead><tr>";
		$array=[];
		//Header
		for ($i=0; $i<mysqli_num_fields($result); $i++) {
			$title=mysqli_fetch_field($result);
			$name=$title->name;
			array_push($array, $name);
			echo "<th> $name </th>";
		}
		echo "</thead></tr>";
		//Content
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			foreach ($array as $field){
				$html = htmlspecialchars($row[$field], ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
				echo "<td>" . $html . "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	else {
		echo "<table>
				<tr style = \"background-color: yellow\">
					<th>
						Nessuna posizione trovata del ciclista $cod_ciclista nella tappa $cod_tappa.
					</th>
				</tr>
				</table>";
	}
?>

</body>
</html>