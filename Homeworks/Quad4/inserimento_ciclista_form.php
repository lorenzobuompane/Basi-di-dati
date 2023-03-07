<html>
<link rel="stylesheet" href="https://www.w3schools.com/css/css_colors.asp"> 
<body>

<h1>Inserimento ciclista</h1>

<form action="inserimento_ciclista.php">

	<label for="cod_ciclista">Codice Ciclista:</label>
	<input type="text" id="cod_ciclista" name="cod_ciclista">  
	<br>
	<br>
	<label for="nome_ciclista">Nome Ciclista:</label>
	<input type="text" id="nome_ciclista" name="nome_ciclista">  
	<br>
	<br>
	<label for="cognome_ciclista">Cognome Ciclista:</label>
	<input type="text" id="cognome_ciclista" name="cognome_ciclista">  
	<br>
	<br>
	<label for="nazione_ciclista">Nazionilità Ciclista:</label>
	<input type="text" id="nazione_ciclista" name="nazione_ciclista">  
	<br>
	<br>
	<label for="cod_squadra">Codice Squadra:</label>
    <select id="cod_squadra" name="cod_squadra">
    <option value=''>Seleziona un codice squadra</option>
    <?php
        //Connessione a MySQL
		$con = mysqli_connect('localhost','root','','campionato');

		if (mysqli_connect_errno()) {
			die ('Failed to connect to MySQL: ' . mysqli_connect_error());
		} 

		//Select codici squadra
		$cod_squadra = "SELECT CodS FROM SQUADRA ORDER BY CodS";
		
		$result = mysqli_query ( $con, $cod_squadra );
		if (!$result){
			die ( 'Query error: ' . mysqli_error ( $con ) );
		}

		if (mysqli_num_rows ( $result ) > 0) {
			while($row = mysqli_fetch_array($result)) {
				$cod_squadra = $row["CodS"];
				echo "<option value='$cod_squadra'>$cod_squadra</option>";
			}
		}

    ?>
    </select>
    <br>
    <br>
	<label for="anno_ciclista">Anno nascita Ciclista:</label>
	<input type="number" id="anno_ciclista" name="anno_ciclista">  
	<br>
	<br>

	<input type="submit" value="Inserisci">

</form>


</body>
</html>