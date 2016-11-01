<html>
	<head>
		<script language="javascript" type="text/javascript" src="datetimepicker.js"></script>
		<title>G.R.I.AL. 2.0</title>
	</head>
	<body bgcolor="#FFFFFF">
		<table border="0" width="100%" id="table2">
			<tr>
				<td width="22%"><font face="Verdana" size="1" color="black"><p align="left"><b>G.R.I.AL. 2.0</b></p></td>
				<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>Si no es posa data mirarà un mes en darrera</b></p></td>
				<td width="22%"><font face="Verdana" size="1" color="black"><p align="right"><b>Gestio Remota d'Incidencies d'ALumnes (Versió 2.0)</b></font></p></td>
			</tr>
		</table><hr>

		<?php include "connectaBD.php";include "PassaVars.php";
		require_once ('../config.php');
		global $USER;
		$userid=$USER->id;
		if(!isloggedin()){
		header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }
		else {
			$idprofe=0;
			$cohort=43;
			$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND (cohortid='$cohort'))";
			$result2=mysql_query($sql2, $conexion);
			while($row2=mysql_fetch_row($result2)){
				$idprofe=$row2[0];
			}
			if (($userid==7) OR (($userid <> 1) AND ($userid <> 7) AND ($idprofe <> 0))){
				$tipus = $_POST["tipus"];
				$data1 = $_POST["data1"];
				$data2 = $_POST["data2"];
				$triacurs[] = $_POST["triacurs[]"];
echo "<font face='Verdana' size='1' color='blue'>
<p align='center'><b>Novetats de la versió 2.0:</b><br><br>
- Permet fer cerca de varis grups alhora (Ctrl + Click).<br>
- Fa les consultes molt més ràpidament.<br>
- Al final del llistat teniu estadístiques globals.<br><br>
";
				echo "
				<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>				
					<tbody>
						<tr align='center'>
							<td width='100%'>	
								<form method='get' action='incidencies_alumnes_llistat.php?data1=$data1&data2=$data2&tipus=$tipus&triacurs=$triacurs'>
									<font face='Arial' size='2'>";
									echo "
									<select name='tipus'>
										<option value='T'>1. Tria incidencia</option>
										<option value='T'>Totes</option>
										<option value='P'>Observacions</option>
										<option value='J'>Faltes justificades</option>
										<option value='R'>Retards</option>
										<option value='F'>Faltes no justificades</option>
										<option value='E'>Expulsions</option>
										<option value='S'>Sancions</option>
									</select>
									<br>
									<br>";

echo "<select  multiple='multiple' name='triacurs[]' class='select' >
	<option value=''>2. Tria grup</option>";
	
	$sql31 = "SELECT * FROM mdl_cohort WHERE name LIKE '%ALUM%' ORDER BY name ASC";
	$result31=mysql_query($sql31, $conexion);
	while($row31=mysql_fetch_row($result31)){
		$nom_cohort=$row31[2];
		echo "<option value='$row31[0]'>".substr($nom_cohort,5)."</option>";
	}
echo "</select>";

echo"<br>";
echo"<br>";

echo"3. Tria dates <i>(Si ho deixes en blanc cercara un mes)</i><br><br>";

echo <<< HTML
Del: <input name="data1" id="data1" type="text" size="7"><a href="javascript:NewCal('data1','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a><br><br>
Al:    <input name="data2" id="data2" type="text" size="7"><a href="javascript:NewCal('data2','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a><br><br>
HTML;
echo "
<input value='4. Consulta' type='submit'>";

									echo "</font>
								</form>
							</td>
						</tr>
					</tbody>
				</table>";	
				include "desconnectaBD.php";
				}
				else{
					echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
				}
			}
		?>
		<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p>
	</body>
</html>