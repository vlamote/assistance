<html><head><title>R.O.C.S.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="25%"><font face="Verdana" size="1"><p align="left"><a href="reserva_aula_info_cs_formulari.php" title="Reserva un PC per a dos alumnes una hora">Reserva</a> | <a href="reserva_aula_info_cs_alum.php" title="Llista de les reserves fetes fins ara">Llista</a> | <a href="reserva_aula_info_cs.php" title="Ocupació de les aules a vista d'ocell">Ocupació</a> | <a href="reserva_aula_info_cs_cerca_formulari.php" title="Consulta les reserves fetes d'un alumne">Consulta</a> | <a href="reserva_crea_aula_info_cs.php" title="Esborra TOTES les reserves">Esborra</a> | <a href="reserva_aula_info_cs_baixa_formulari.php" title="Dona de baixa un PC">Baixa</a></font></p></td>
<td width="50%"><font face="Verdana" size="1" color="red"><p align="center"><b>Cursor a sobre per a detalls. Clic per a més accions</b></p></td>
<td width="25%"><font face="Verdana" size="1"><p align="right"><b>Reserva d'Ordinadors per al Crèdit de Síntesi</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

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

	if (($userid==7) OR (($userid ==2448) AND ($idprofe <> 0))){
	/***************************************************************************************************/

	$dia = $_POST["dia"];
	$hora = $_POST["hora"];
	$idalumne1 = $_POST["idalumne1"];
	$idalumne2 = $_POST["idalumne2"];
	$idprofe = $_POST["idprofe"];
	$aula= $_POST["aula"];
	$pc= $_POST["pc"];

	$comptador=1;

	echo "
		<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
		<tbody>
				<td width='100%'>

					<form method='POST' action='reserva_aula_info_cs_baixa_llistat.php'>

						<p align='center'>
						<select  name='aula' class='select' >
							<option value=''>1. Tria aula</option>
							<option value='1'>Info 01................................</option>
							<option value='2'>Info 02................................</option>
							<option value='3'>Info 03 (Carro Edifici Roig)</option>
							<option value='4'>Info 04 (Carro Edifici Verd)</option>
						</select>
						</p>
						<p align='center'>
						<select  name='pc' class='select' >
							<option value=''>2. Tria PC</option>
							<option value='1'>01........................................</option>
							<option value='2'>02........................................</option>
							<option value='3'>03........................................</option>
							<option value='4'>04........................................</option>
							<option value='5'>05........................................</option>
							<option value='6'>06........................................</option>
							<option value='7'>07........................................</option>
							<option value='8'>08........................................</option>
							<option value='9'>09........................................</option>
							<option value='10'>10......................................</option>
							<option value='11'>11......................................</option>
							<option value='12'>12......................................</option>
							<option value='13'>13......................................</option>
							<option value='14'>14......................................</option>
							<option value='15'>15......................................</option>
							<option value='16'>16......................................</option>
							<option value='17'>17......................................</option>
							<option value='18'>18......................................</option>
						</select>
						</p>
						<p align='center'>
						<input value='3. Dona de baixa' type='submit'>
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