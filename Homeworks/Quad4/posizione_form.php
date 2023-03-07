<html>
<link rel="stylesheet" href="https://www.w3schools.com/css/css_colors.asp"> 
<body>

<h1>Posizione Ciclista in Tappa</h1>

<form action="posizione.php">
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
	
	<label for="cod_tappa">Tappa:</label>
    <input type="text" id="cod_tappa" name="cod_tappa">  
	<br>
	<br>
	
	
    <input type="submit" value="Cerca">
</form> 


</body>
</html>