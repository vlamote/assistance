<html><head><title>R.O.C.S.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="25%"><font face="Verdana" size="1"><p align="left"><a href="reserva_aula_info_cs_formulari.php" title="Reserva un PC per a dos alumnes una hora">Reserva</a> | <a href="reserva_aula_info_cs_alum.php" title="Llista de les reserves fetes fins ara">Llista</a> | <a href="reserva_aula_info_cs.php" title="Ocupació de les aules a vista d'ocell">Ocupació</a> | <a href="reserva_aula_info_cs_cerca_formulari.php" title="Consulta les reserves fetes d'un alumne">Consulta</a> | <a href="reserva_crea_aula_info_cs.php" title="Esborra TOTES les reserves">Esborra</a> | <a href="reserva_aula_info_cs_baixa_formulari.php" title="Dona de baixa un PC">Baixa</a></font></p></td>
<td width="50%"><font face="Verdana" size="1" color="red"><p align="center"><b>Tria les opcions -(*) obligatòries- i fes clic al boto</b></p></td>
<td width="25%"><font face="Verdana" size="1"><p align="right"><b>Reserva d'Ordinadors per al Crèdit de Síntesi</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Temporals.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

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

	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=43) OR (cohortid=44) OR (cohortid=45) OR (cohortid=59)))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
            }

	if (($userid==7) OR (($userid <> 1) AND ($idprofe <> 0))){
	/***************************************************************************************************/

	$dia = $_POST["dia"];
	$hora = $_POST["hora"];
	$idalumne1 = $_POST["idalumne1"];
	$idalumne2 = $_POST["idalumne2"];
	$idprofe = $_POST["idprofe"];
	$aula= $_POST["aula"];

	$comptador=1;

	echo "
		<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
		<tbody>
				<td width='100%'>
					<form method='POST' action='reserva_aula_info_cs_llistat.php'>
						<p align='center'>
						<select  name='dia' class='select' >
							<option value=''>1. Tria dia (*)</option>";
								$i=1;
								for($i==1;$i<=$DIES_CS;$i++){echo "<option value='$i'>Dia 0$i</option>";}
						echo "
						</select>
						</p>
						<p align='center'>
						<select  name='hora' class='select' >
							<option value=''>2. Tria hora (*)</option>";
							$i=1;
							for($i==1;$i<=$HORES_CS;$i++){echo "<option value='$i'>Hora 0$i</option>";}
						echo "
						</select>
						</p>
						<p align='center'>
						<select  name='idalumne1' class='select' >
							<option value=''>3. Tria alumne 1 (*)</option>";
							/*MIRO A TOTS ELS USUARIS PER ORDRE ALFABETIC*/
							$sql3="SELECT * FROM mdl_user ORDER BY lastname";
							$result3=mysql_query($sql3, $conexion);
							while($row3=mysql_fetch_row($result3)){
								$idalumne=$row3[0];
								$alumne=$row3[11].", ".$row3[10];
								/*MIRO SI SON MEMBRES D'UNA COHORT D'ALUMNE*/
								$sql4="SELECT * FROM mdl_cohort a, mdl_cohort_members b WHERE ((a.idnumber LIKE '%ALUM%') AND (b.userid='$idalumne') AND (b.cohortid=a.id))";
								$result4=mysql_query($sql4, $conexion);
								while($row4=mysql_fetch_row($result4)){
									$grup=$row4[3];
									$comptador=$comptador+1;
									echo utf8_encode("<option value='$idalumne'>$alumne ($grup)</option>");
								}
							}
							echo"</select>
						</p>
						<p align='center'>
						<select  name='idalumne2' class='select' >
							<option value=''>4. Tria alumne 2</option>";
							/*MIRO A TOTS ELS USUARIS PER ORDRE ALFABETIC*/
							$sql33="SELECT * FROM mdl_user ORDER BY lastname";
							$result33=mysql_query($sql33, $conexion);
							while($row33=mysql_fetch_row($result33)){
								$idalumne=$row33[0];
								$alumne=$row33[11].", ".$row33[10];
								/*MIRO SI SON MEMBRES D'UNA COHORT D'ALUMNE*/
								$sql44="SELECT * FROM mdl_cohort a, mdl_cohort_members b WHERE ((a.idnumber LIKE '%ALUM%') AND (b.userid='$idalumne') AND (b.cohortid=a.id))";
								$result44=mysql_query($sql44, $conexion);
								while($row44=mysql_fetch_row($result44)){
									$grup=$row44[3];
									$comptador=$comptador+1;
									echo utf8_encode("<option value='$idalumne'>$alumne ($grup)</option>");
								}
							}
							echo"</select>
						</p>
						<p align='center'>
						<select  name='aula' class='select' >
							<option value=''>5. Tria aula (Els de 1r han de triar Info 01 o Info 02 i els de 4t han de triar Info 03)</option>";
							$i=1;
							for($i==1;$i<=$AULES_DISPONIBLES;$i++){echo "<option value='$i'>Info 0$i</option>";}
						echo "
						</select>
						</p>
						<p align='center'>
						<input value='6. Reserva' type='submit'>
						</p>
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

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>