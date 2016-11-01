<html><head><title>CON.EX.A.</title></head>
<table border="0" width="100%" id="table2">
	<tr>
		<td width="22%"><font face="Verdana" size="1"><p align="left"><b>
			<a href="http://iessitges.xtec.cat/assistencia/llistat_alumnes.php" target="_self" title="Consulta per alumne">Alumne</a> |
			<a href="http://iessitges.xtec.cat/assistencia/notes_grups_formulari.php" target="_self" title="Consulta per grup">Grup</a> |
			<a href="http://iessitges.xtec.cat/assistencia/notes_materies_formulari.php" target="_self" title="Consulta per materia">Materia</a> | 
			<a href="https://saga.xtec.cat/entrada/nodes" target="_blank" title="Ves al SAGA">Saga</a></font></td>
		</td>
		<td width="56%"><font face="Verdana" size="1" color="black"><p align="center"><b>CONSULTA DELS EXPEDIENTS DELS ALUMNES</b></p></td>
		<td width="22%"><font face="Verdana" size="1"><p align="right"><b>CONsulta.EXpedient.Alumnes.</b></p></font></td>
	</tr>
</table>
<hr>

<?php include "connectaBD.php";include "PassaVars.php";

	/*******************CONTROL DE ACCES INICI********************************************************/
	require_once ('../config.php');
	global $USER;
	$userid=$USER->id;
	if(!isloggedin()){
		header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }
	else {
		$idprofe=0;

		/*****************************************************/
		/*COHORTS DE TUTORS: 35 36 37 38 39 40 41 42  83 84 85*/
		/*COHORT DE COORDINADORS: 44*/
		/*COHORT DE PROFESSORS: 43*/
		/*COHORT DE DIRECCIO: 45*/
		/*****************************************************/

		$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=43) OR  (cohortid=44) OR (cohortid=45) OR (cohortid=59)))";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){
			$idprofe=$row2[0];
		}

		if (($userid==7) OR (($userid <> 1) AND ($idprofe <> 0))){

			/***************************************************************************************************/

			$idalumne = $_POST["idalumne"];
			$data1    = $_POST["data1"];
			$idcohort   = $_POST["idcohort"];
			$nom_nota   = $_POST["nom_nota"];
			$compta_alumnes=0;
			$compta_grups=0;

			echo "<table  style='text-align: left margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
			<tbody>
				<tr align='center'>
					<td width='100%'>
						<form method='POST' action='notes_grups_llistat.php'>
							<select name='idcohort' class='select'>
								<option value=''>Tria curs ...</option>";

							echo"<option value='BAT1'>BAT1</option>
								<option value='BAT2'>BAT2</option>
								<option value='CAGS'>CAGS</option>
								<option value='CFGM1'>CFGM1</option>
								<option value='CFGM2'>CFGM2</option>
								<option value='CFGS1'>CFGS1</option>
								<option value='CFGS2'>CFGS2</option>
								<option value='ESO1'>ESO1</option>
								<option value='ESO2'>ESO2</option>
								<option value='ESO3'>ESO3</option>
								<option value='ESO4'>ESO4</option>
								<option value='PFI'>PFI</option>";
/*
								$sql2="SELECT * FROM mdl_cohort WHERE (idnumber LIKE '%ALUM%') ORDER BY idnumber";
								$result2=mysql_query($sql2, $conexion);
								while($row2=mysql_fetch_row($result2)){
									$grup=$row2[0];
									$nom_grup=str_replace ("ALUM","",$row2[3]);
									$compta_grups=$compta_grups+1;
									echo "<option value=$row2[0]>$compta_grups: $nom_grup</option>";
								}
*/
/*******************************************************************************************/
/*Cal assegurar-se a la BD que el nom de la tasca es diu exactament així a tots els cursos Moodle*/
/*******************************************************************************************/
					echo "</select>
							<select name='nom_nota' class='select'>
								<option value=''>Tria avaluacio</option>
								<option value='Inicial'>Inicial</option>
								<option value='1r. trimestre'>1r. trimestre</option>
								<option value='2n. trimestre'>2n. trimestre</option>
								<option value='3r. trimestre'>3r. trimestre</option>
								<option value='Extraordinaria juny'>Extraordinaria juny</option>
								<option value='Extraordinaria setembre'>Extraordinaria setembre</option>
								<option value='Total del curs'>Final</option>
							</select>
							<input value='Troba' type='submit'>
						</form>
					</td>
				</tr>
			</tbody>
		</table>";
	
		include "desconnectaBD.php";
	
		/*******************CONTROL DE ACCES FINAL********************************************************/
		}
		else{
			echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
			}
	}
	/******************************************************************************************************/
?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></body></html>