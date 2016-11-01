<html>	<head><title>INCID.INFO.</title>
<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#estadistiquesprofes").tablesorter({
sortList: [[0,0],[1,1]]
});
});
</script>
</head><body>
<table border="0" width="100%" id="table2">
<tr>
<td width="20%"><p align="left"><font face="Verdana" size="1"><b>INCID.INFO.</b> | <a href="/mod/data/edit.php?d=28">Posar una incidència</a> | <a href="/assistencia/incidencies_informatiques_formulari.php">Nova consulta</a></td>
<td width="55%"><p align="center"><font face="Verdana" size="1" color="red">Pica al LED per al detall de la incidència</font> <font face="Verdana" size="1" color="black">Contacta al <a href="http://iessitges.xtec.cat/message/index.php?id=2848" title="Victor Lamote de Grignon i Alifonso" target="blank">Coordinador</a></font></P></td>
<td width="30%"><p align="right"><font face="Verdana" size="1"><b>INCIDencies INFOrmatiques</b></font></p></td>
</tr>
</table>
<hr>
<?php include "connectaBD.php";include "PassaVars.php";include "sessionlib.php";include "Funcions_Matrius.php";
require_once ('../config.php');
global $USER;
$userid=$USER->id;
if(!isloggedin()){
	header('Location: http://iessitges.xtec.cat/login/index.php?id=284');
}
else {
	$idprofe=0;
	$cohort=43;
	$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND (cohortid='$cohort'))";
	$result2=mysql_query($sql2, $conexion);
	while($row2=mysql_fetch_row($result2)){
		$idprofe=$row2[0];
	}
	if (($userid==7) OR ($userid==1937) OR (($userid <> 1) AND ($userid <> 7) AND ($idprofe <> 0))){

		$alumne="---";
		$profe="---";
		$sessio="---";
		$identificador=0;
		$identificadorObertes=0;
		$identificadorActives=0;
		$enllas="mod/attforblock/view.php";
		$sessio="---";
		$assistencia="---";
		$curs="---";
		$nomcurs="---";
		$nomgrup="---";
		$cursoficial="N/A";
		$grupoficial="N/A";	
		$compta_alumnes=1;
		$data1= $_GET["data1"];
		$data2 = $_GET["data2"];
		$dataentrada1= strtotime($data1);
		$dataentrada2= strtotime($data2);
		$compta_contractat=0;		
		$compta_coordinador=0;
		$compta_extern=0;
		$compta_intern=0;
		$compta_preventiu=0;
		$compta_pendents=0;
		$llista_dates='/';
		$abans=time();
		$totals_hores_falta=0;
		$diferit=3*30*24*60*60;

		if ($data1=="" AND $data2==""){
			$dataentrada1=time()-$diferit;
			$data1=date("d-m-y",$dataentrada1);
			$dataentrada2=time();
			$data2=date("d-m-y",$dataentrada2);
		}
		echo"<p align='center'><font face='Verdana' size='1'>	<b>Periode de consulta: </b>$data1<b> a </b>$data2</p></font><div align='center'>
		<table id='estadistiquesprofes' width='700px' class='tablesorter'><thead>
		<tr>
			<th width='050px' align='center'><b>Estat</b></th>
			<th width='070px' align='center'><b>Data</b></th>
			<th width='200px' align='center'><b>Informant</b></th>
			<th width='100px' align='center'><b>Espai</b></th>
			<th width='100px' align='center'><b>Diagnosi</b></th>
			<th width='130px' align='center'><b>Tècnic</b></th>
		</tr></thead>	";

		/**************************************************************************************************/
		/*TRIO LES SESSIONS QUE TENEN DATES ENTRE LES TRIADES I LA BASE DE DADES DE VALOR dataid=28*/
		/************************************************************************************************/
		$sql01 = "SELECT * FROM mdl_data_records WHERE ((timecreated>= '$dataentrada1') AND (timecreated<='$dataentrada2')) AND (dataid='28') order by timecreated desc";
		$result01=mysql_query($sql01, $conexion);
		while($row01=mysql_fetch_row($result01)){

			$sessio=$row01[0];
			$informant=$row01[1];
			$grup=$row01[2];
			$datasessio=$row01[4];
			$dataentrada=date("Y/m/d H:i", $datasessio);

			/***************************************************/
			/*ESBRINO CONTINGUT CAMP ACTIVA (FIELDID=548)*/
			/**************************************************/
			$sql14 = "SELECT * FROM mdl_data_content WHERE recordid='$sessio' AND fieldid='548'";
			$result14=mysql_query($sql14, $conexion);
			while($row14=mysql_fetch_row($result14)){
				$activa=$row14[3];
			}

			/******************************************/
			/*ESBRINO CONTINGUT CAMP INFORMANT*/
			/*****************************************/
			$sql33="SELECT * FROM mdl_user WHERE id='$informant'";
			$result33=mysql_query($sql33, $conexion);
			while($row33=mysql_fetch_row($result33)){
				$idalumne=$row33[0];
				$alumne=$row33[11].", ".$row33[10];
				$incidencies[$identificador][0]=$alumne;
			}

			/*************************************************/
			/*ESBRINO CONTINGUT CAMP ESPAI (FIELDID=383)*/
			/*************************************************/
			$sql11 = "SELECT * FROM mdl_data_content WHERE recordid='$sessio' AND fieldid='383'";
			$result11=mysql_query($sql11, $conexion);
			while($row11=mysql_fetch_row($result11)){
				$espai=$row11[3];
				$incidencies[$identificador][1]=$espai;
			}
			/*************************************************/
			/*ESBRINO CONTINGUT CAMP CAUSA (FIELDID=384)*/
			/*************************************************/
			$sql12 = "SELECT * FROM mdl_data_content WHERE recordid='$sessio' AND fieldid='384'";
			$result12=mysql_query($sql12, $conexion);
			while($row12=mysql_fetch_row($result12)){
				$causa=$row12[3];
				$incidencies[$identificador][2]=$causa;
			}

			/*************************************************/
			/*ESBRINO CONTINGUT CAMP TECNIC (FIELDID=382)*/
			/*************************************************/
			$sql13 = "SELECT * FROM mdl_data_content WHERE recordid='$sessio' AND fieldid='382'";
			$result13=mysql_query($sql13, $conexion);
			while($row13=mysql_fetch_row($result13)){
				$tecnic=$row13[3];
				$incidencies[$identificador][3]=$tecnic;
			}

			/*************************************************/
			/*ESBRINO CONTINGUT CAMP DESCRIPCIO (FIELDID=375)*/
			/*************************************************/
			$sql14 = "SELECT * FROM mdl_data_content WHERE recordid='$sessio' AND fieldid='375'";
			$result14=mysql_query($sql14, $conexion);
			while($row14=mysql_fetch_row($result14)){
				$descripcio=str_replace("'","_",$row14[3]);
			}

			if($activa=='Activa'){
				/*ACTIVADES -ROIG-*/
				$acronim="1";
				$identificadorActives=$identificadorActives+1;;
			}
			else{
				if ($tecnic==''){
					/*OBERTES -GROC-*/
					$acronim="2";
					$identificadorObertes=$identificadorObertes+1;;
				}
				else{
					/*FETES -VERD-*/
					$acronim="3";
				}
			}

			$LED="imatges/LED_incidencia_".$acronim.".gif";		

			$clau_sessio=FALSE;
			$clau_sessio=sesskey();
			$enllas="/mod/data/edit.php?d=28&rid=".$sessio."&sesskey=".$clau_sessio;
			$enllas2="/assistencia/troba_profe_formulari.php";
			echo"
			<tr>
				<td align='center' bgcolor='$color' width='070px'><font face='Verdana' size='1' color='#FFFFFF'><a href='$enllas' title='$descripcio'  target='blank'><img src='$LED'></a> $acronim</font></td>
				<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$dataentrada</font></td>
				<td align='left'       bgcolor='$color' width='200px'><font face='Verdana' size='1'><a href='$enllas2' title='Horari profe' target='blank'>$alumne</a></font></td>
				<td align='left'       bgcolor='$color' width='100px'><font face='Verdana' size='1'>$espai</font></td>
				<td align='left'       bgcolor='$color' width='100px'><font face='Verdana' size='1'>$causa</font></td>
				<td align='left'       bgcolor='$color' width='130px'><font face='Verdana' size='1'>$tecnic</font></td>
			</tr>";

			$identificador=$identificador+1;
		}

	$durada=time()-$abans;

	$identificadorResoltes=$identificador-$identificadorObertes-$identificadorActives;

echo "
<p align='center'>
<font face='Verdana' size='1'>
<b>Trobades </b>$identificador <b>incidencies (Obertes: </b>$identificadorObertes<b>, Activades:</b> $identificadorActives<b>, Resoltes:</b> $identificadorResoltes <b>-recerca feta en </b>$durada <b>[sg]-)</b></font></p>";

		/*******************CONTROL DE ACCES FINAL********************************************************/
	}	
	else{
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
	}
echo "</tbody></table>";

/************************************/
/*A LA MATRIU $INCIDENCIES ES            */
/*ON DESEM TOTS ELS REGISTRES        */
/*PER L'ESTADISTICA                                    */
/*           0                      1            2              3       */
/*INFORMANT ESPAI CAUSA TECNIC*/
/**********************************/
$color="#0000ff";
echo "<table id='estadistiquesprofes2' width='400px' class='tablesorter'>";
echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#000000'><b>ESTADÍSTIQUES</b></td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'></td>";
	echo "</tr>";

	/*EM CREO UNA SUBMATRIU DELS INFORMANTS*/

	$color="#666699";
	echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Informant</td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Incidències</td>";
	echo "</tr>";

	for($i = 0; $i < $identificador; $i++){
		$submatriu[$i]=$incidencies[$i][0];
	}

	$submatriu=repeatedElements($submatriu, TRUE);

	foreach ($submatriu as $key => $row) {
		$color="#FFFFFF";
		$vumetre="";
		for ($i=0; $i<$row['vegades']; $i++){
			$vumetre=$vumetre."#";
		}
		echo "<tr>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$row['valor']."</td>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$vumetre.$row['vegades']."</td>";
		echo "</tr>";
	}

	/*EM CREO UNA SUBMATRIU DELS ESPAIS*/

	echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Espai</td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Incidències</td>";
	echo "</tr>";

	for($i = 0; $i < $identificador; $i++){
		$submatriu[$i]=$incidencies[$i][1];
	}

	$submatriu=repeatedElements($submatriu, TRUE);

	foreach ($submatriu as $key => $row) {
		$vumetre="";
		for ($i=0; $i<$row['vegades']; $i++){
			$vumetre=$vumetre."#";
		}
		echo "<tr>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$row['valor']."</td>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$vumetre.$row['vegades']."</td>";
		echo "</tr>";
	}

	/*EM CREO UNA SUBMATRIU DE LES CAUSES*/

	echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Causa</td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Incidències</td>";
	echo "</tr>";

	for($i = 0; $i < $identificador; $i++){
		$submatriu[$i]=$incidencies[$i][2];
	}

	$submatriu=repeatedElements($submatriu, TRUE);

	foreach ($submatriu as $key => $row) {
		$vumetre="";
		for ($i=0; $i<$row['vegades']; $i++){
			$vumetre=$vumetre."#";
		}
		echo "<tr>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$row['valor']."</td>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$vumetre.$row['vegades']."</td>";
		echo "</tr>";
	}

	/*EM CREO UNA SUBMATRIU DELS TECNICS*/

	echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Tècnic</td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Incidències</td>";
	echo "</tr>";

	for($i = 0; $i < $identificador; $i++){
		$submatriu[$i]=$incidencies[$i][3];
	}

	$submatriu=repeatedElements($submatriu, TRUE);

	foreach ($submatriu as $key => $row) {
		$vumetre="";
		for ($i=0; $i<$row['vegades']; $i++){
			$vumetre=$vumetre."#";
		}

		echo "<tr>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$row['valor']."</td>";
			echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$vumetre.$row['vegades']."</td>";
		echo "</tr>";
	}
	
	echo "</table>";

include "desconnectaBD.php";
}
?><hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2016</font></p></font></body></html>