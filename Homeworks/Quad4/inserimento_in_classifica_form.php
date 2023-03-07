<html>
<link rel="stylesheet" href="https://www.w3schools.com/css/css_colors.asp"> 
<body>

<h1>Inserimento in classifica</h1>

<form action="inserimento_in_classifica.php">

	<label for="cod_ciclista">Codice ciclista:</label>
    <select id="cod_ciclista" name="cod_ciclista">
	<option value=''>Seleziona un codice ciclista</option>
    <?php
        //Connessione a MySQL
		$con = mysqli_connect('localhost','root','','campionato');

		if (mysqli_connect_errno()) {
			die ('Failed to connect to MySQL: ' . mysqli_connect_error());
		} 

		//Select codici ciclista
		$cod_ciclista = "SELECT CodC FROM CICLISTA ORDER BY CodC";
		
		$result = mysqli_query ( $con, $cod_ciclista );
		if (!$result){
			die ( 'Query error: ' . mysqli_error ( $con ) );
		}

		if (mysqli_num_rows ( $result ) > 0) {
			while($row = mysqli_fetch_array($result)) {
				$cod_ciclista = $row["CodC"];
				echo "<option value='$cod_ciclista'>$cod_ciclista</option>";
			}
		}

    ?>
    </select>
	<br>
    <br>
	<label for="cod_tappa">Codice tappa: </label>
	<select id="cod_tappa" name="cod_tappa">
	<option value=''>Seleziona un codice tappa</option>
	<?php
		//Connessione a MySQL
		$con = mysqli_connect('localhost','root','','campionato');

		if (mysqli_connect_errno()) {
			die ('Failed to connect to MySQL: ' . mysqli_connect_error());
		} 

		//Select codici ciclista
		$cod_tappa = "SELECT DISTINCT CodT FROM TAPPA ORDER BY CodT";
		
		$result = mysqli_query ( $con, $cod_tappa );
		if (!$result){
			die ( 'Query error: ' . mysqli_error ( $con ) );
		}

		if (mysqli_num_rows ( $result ) > 0) {
			while($row = mysqli_fetch_array($result)) {
				$cod_tappa = $row["CodT"];
				echo "<option value='$cod_tappa'>$cod_tappa</option>";
			}
		}

	?>
	</select>
	<br>
    <br>
	<label for="edizione">Edizione: </label>
	<select id="edizione" name="edizione">
	<option value=''>Seleziona edizione:</option>
	<?php
		//Connessione a MySQL
		$con = mysqli_connect('localhost','root','','campionato');

		if (mysqli_connect_errno()) {
			die ('Failed to connect to MySQL: ' . mysqli_connect_error());
		} 

		//Select codici ciclista
		$edizione = "SELECT DISTINCT Edizione FROM TAPPA ORDER BY Edizione";
		
		$result = mysqli_query ( $con, $edizione );
		if (!$result){
			die ( 'Query error: ' . mysqli_error ( $con ) );
		}

		if (mysqli_num_rows ( $result ) > 0) {
			while($row = mysqli_fetch_array($result)) {
				$edizione = $row["Edizione"];
				echo "<option value='$edizione'>$edizione</option>";
			}
		}

	?>
	</select>
	<br>
    <br>
	<label for="posizione">Posizione:</label>
	<input type="number" id="posizione" name="posizione"> 
	
	<br>
	<br>
	<input type="submit" value="Inserisci">

	

</form>


</body>
</html>