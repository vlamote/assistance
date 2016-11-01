<html>
	<head><title>Connexió a Base de Dades</title></head>
		<body>
			<?php
				 //HOST DEL MySQL (GENERALMENT localhost)
				$dbhost="localhost";

				//NOM D'USUARI PER A ACCEDIR A LA BASE DE DADES
				$dbusuario="benapresmoodle";

				//CLAU PER A ACCEDIR A LA BASE DE DADES
				$dbpassword="benapresmoodle";

				//SELECCIONAR BASE DE DADES
				$db="benapresdbmoodle";

				//CONNEXIO
				$conexion = mysql_connect($dbhost, $dbusuario, $dbpassword);
				mysql_select_db($db, $conexion);
			?>
		</body>
</html>
