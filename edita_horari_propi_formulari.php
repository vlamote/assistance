<html><head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<title>C.HO.P.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="28%"><font face="Verdana" size="1">
<a href="http://iessitges.xtec.cat/assistencia/crea_horari_propi_formulari.php" title="Crea les teves sessions d'horari">Crea</a> | 
<a href="http://iessitges.xtec.cat/assistencia/edita_horari_propi_formulari.php" title="Modifica dia, hora, aula o dates de les teves sessions d'horari">Edita</a> | 
<a href="http://iessitges.xtec.cat/assistencia/esborra_horari_propi_formulari.php" title="Esborra les teves sessions d'horari">Esborra</a> | 
<a href="http://iessitges.xtec.cat/assistencia/horari_profe_formulari.php" title="Comprova com queden les teves sessions d'horari" target="_blank">Revisa</a>
</font></td>
<td width="56%"><font face="Verdana" size="1" color="red">1. Tria materia 2. Tria assistencia 3. Tria grup 4. Tria dia 5. Tria hora 6. Tria aula 7. Tria dates 8. Tria modificacions 9. Prem el boto</p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>Edita Horari Propi</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
mysql_query("SET NAMES 'utf8'");
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

$idalumne=$userid;

$ID_assistencia=$_POST["ID_assistencia"];
$ID_grup=$_POST["ID_grup"];

$dia=$_POST["dia"];
$hora=$_POST["hora"];
$durada=$_POST["durada"];

$ID_aula=$_POST["ID_aula"];

$data1=$_POST["data1"];
$data2=$_POST["data2"];

$dia2=$_POST["dia2"];
$hora2=$_POST["hora2"];
$durada2=$_POST["durada2"];

$ID_aula2=$_POST["ID_aula2"];

$data12=$_POST["data12"];
$data22=$_POST["data22"];

$ara=time();
$dia_ara=date("d",$ara);
$mes_ara=date("m",$ara);

/*SI CREES HORARI ENTRE GENER I JUNY*/
if($mes_ara<'7'){
$any_ara=date("y",$ara)+1999;
$any_seguent=date("y",$ara)+2000;
}
/*SI NO*/
else{
$any_ara=date("y",$ara)+2000;
$any_seguent=date("y",$ara)+2001;
}
/*ESBRINO NOM PROFE*/
$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	
	$alumne=$row2[11].", ".$row2[10];
	
	echo "<p align='center'><b><font face='Verdana' size='2'>Editant horari de:</b> $alumne ($idalumne)<b><br></font></p>";
}

echo "
<p align='left'><font face='Verdana' size='2' color='red'>NOTES:</b><br><br>
1. Assegureu-vos, primer, que <b>heu creat la sessió que voleu editar amb aquesta eina C.HO.P.</b><br><br>
2. Assegureu-vos de <b>posar les mateixes dades</b> que vau posar en crear la sessió que voleu editar.<br><br>";

echo "<table  style='text-align: left margin-left: 200px; margin-right: auto; width:200px; height: 44px;' border='0'>

  <tbody>

    <tr align='left'>

      <td width='50%'>

		<font face='Verdana' size='2' color='black'><b>DADES ORIGINALS:</b><br><br>

		<form name =\"triaassistencia\" action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n\n";

			echo"<select name=\"id1\" class='select' onChange=\"this.form.submit()\">\n";

			echo "<option value=''>1. Tria materia</option>";

			/*PERQUE HI HA REGISTRES REPETITS, NO SE PERQUE*/
			$contexte_anterior=0;

			/*BUSCA TOTS ELS ASSIGNAMENTS ON L'USUARI ES PROFESSOR: (ROLE=3) */
			$sql2="SELECT * FROM mdl_role_assignments WHERE roleid='3' AND userid='$idalumne' ORDER BY contextid ASC";
			$result2=mysql_query($sql2, $conexion);
			while($row2=mysql_fetch_row($result2)){

				$contexte=$row2[2];		

				if($contexte<>$contexte_anterior AND $contexte<>'2' AND $contexte<>'3017') {

					/*TRANSFORMO CURS EN CONTEXT*/
					$sql21 = "SELECT * FROM mdl_context WHERE (id='$contexte')";
					$result21=mysql_query($sql21, $conexion);
					while($row21=mysql_fetch_row($result21)){
			
						$ID_curs=$row21[2];								
					}
					
					/*ESBRINO NOM DEL CURS*/
					$sql3 = "SELECT * FROM mdl_course WHERE (id='$ID_curs' AND visible='1') ORDER BY shortname ASC";
					$result3=mysql_query($sql3, $conexion);
					while($row3=mysql_fetch_row($result3)){
		
						$nom_curs=$row3[3];
						echo "<option value='$row3[0]'>$nom_curs</option>";
						$contexte_anterior=$contexte;
					}			 					
				}
			}
	
		echo "</select>

		</form>

		<form method='POST' action='edita_horari_propi_llistat.php'>

			<select  name='ID_assistencia' class='select' >
	
				<option value=''>2. Tria assistencia</option>";

					/*ESBRINO INSTANCIES ASSISTENCIES EN EL CURS*/
					$sql31 = "SELECT * FROM mdl_attforblock WHERE (course='$id1') ORDER BY name ASC";
					$result31=mysql_query($sql31, $conexion);
					while($row31=mysql_fetch_row($result31)){
		
						$nom_assistencia=$row31[2];
						echo "<option value='$row31[0]'>$nom_assistencia ($row31[0])</option>";	
					}

			echo "</select><br><br>

			<select  name='ID_grup' class='select' >
	
				<option value=''>3. Tria grup</option>";

					/*ESBRINO GRUPS DEL CURS*/
					$sql32 = "SELECT * FROM mdl_groups WHERE (courseid='$id1') ORDER BY name ASC";
					$result32=mysql_query($sql32, $conexion);
					while($row32=mysql_fetch_row($result32)){

						$ID_grup=$row32[0];
						$nom_grup=$row32[3];
						echo "<option value='$ID_grup'>$nom_grup</option>";
					}

			echo "</select><br><br>

			<select  name='dia' class='select' >
	
				<option value=''>4. Tria dia</option>
				<option value='1'>Dilluns</option>
				<option value='2'>Dimarts</option>
				<option value='3'>Dimecres</option>
				<option value='4'>Dijous</option>
				<option value='5'>Divendres</option>

			</select><br><br>
		
			<select  name='hora' class='select' >

				<option value=''>5. Tria hora</option>
				<option value='HM1'>Matí: 1ª hora</option>
				<option value='HM2'>Matí: 2ª hora</option>
				<option value='PM1'>Matí:    PATI 1</option>
				<option value='HM3'>Matí: 3ª hora</option>
				<option value='HM4'>Matí: 4ª hora</option>
				<option value='PM2'>Matí:    PATI 2</option>
				<option value='HM5'>Matí: 5ª hora</option>
				<option value='HM6'>Matí: 6ª hora</option>
				<option value='HT1'>Tarda: 1ª hora</option>
				<option value='HT2'>Tarda: 2ª hora</option>
				<option value='HT3'>Tarda: 3ª hora</option>
				<option value='PT1'>Tarda:      PATI</option>
				<option value='HT4'>Tarda: 4ª hora</option>
				<option value='HT5'>Tarda: 5ª hora</option>
				<option value='HT6'>Tarda: 6ª hora</option>
			}
	
			</select>";

			$compta_alumnes=0;

			echo "<br><br>
	
			<select  name='ID_aula' class='select' >

				<option value=''>6. Tria aula</option>";
		
					$sql31="SELECT * FROM mdl_block_mrbs_area ORDER BY area_name";
					$result31=mysql_query($sql31, $conexion);
					while($row31=mysql_fetch_row($result31)){

						$area=$row31[0];
						$nom_area=$row31[1];

						/*NOMES MOSTRA AULES AMB CAPACITAT <>0 -AIXI NO SURT EL CARRO-*/
						$sql3="SELECT * FROM mdl_block_mrbs_room WHERE area_id='$area' and capacity<>'0' ORDER BY room_name";
						$result3=mysql_query($sql3, $conexion);
						while($row3=mysql_fetch_row($result3)){

							$compta_alumnes=$compta_alumnes+1;
							$nom_sala=$row3[2];
							$nom_sala2=$row3[3];
							$ID_aula=$row3[0];

							echo "<option value='$ID_aula'>$nom_area > $nom_sala ($nom_sala2)</option>";
						}
					}

		echo "</select><br>";

echo <<< HTML
<font face='Arial' size='2' color='black'><br>
7. Des de: <input name="data1" id="data1" type="text" size="7"><a href="javascript:NewCal('data1','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>
Fins a: <input name="data2" id="data2" type="text" size="7"><a href="javascript:NewCal('data2','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a></font>
HTML;

		echo "<font face='Verdana' size='2' color='black'><b><br><br>DADES RENOVADES:</b><br><br>

			<select  name='dia2' class='select' >
	
				<option value=''>8. Tria dia</option>
				<option value='1'>Dilluns</option>
				<option value='2'>Dimarts</option>
				<option value='3'>Dimecres</option>
				<option value='4'>Dijous</option>
				<option value='5'>Divendres</option>

			</select><br><br>
		
			<select  name='hora2' class='select' >

				<option value=''>9. Tria hora</option>
				<option value='HM1'>Matí: 1ª hora</option>
				<option value='HM2'>Matí: 2ª hora</option>
				<option value='PM1'>Matí:    PATI 1</option>
				<option value='HM3'>Matí: 3ª hora</option>
				<option value='HM4'>Matí: 4ª hora</option>
				<option value='PM2'>Matí:    PATI 2</option>
				<option value='HM5'>Matí: 5ª hora</option>
				<option value='HM6'>Matí: 6ª hora</option>
				<option value='HT1'>Tarda: 1ª hora</option>
				<option value='HT2'>Tarda: 2ª hora</option>
				<option value='HT3'>Tarda: 3ª hora</option>
				<option value='PT1'>Tarda:      PATI</option>
				<option value='HT4'>Tarda: 4ª hora</option>
				<option value='HT5'>Tarda: 5ª hora</option>
				<option value='HT6'>Tarda: 6ª hora</option>
			}
	
			</select>";

			$compta_alumnes2=0;

			echo "<br><br>
	
			<select  name='ID_aula2' class='select' >

				<option value=''>10. Tria aula</option>";
		
					$sql312="SELECT * FROM mdl_block_mrbs_area ORDER BY area_name";
					$result312=mysql_query($sql312, $conexion);
					while($row312=mysql_fetch_row($result312)){

						$area2=$row312[0];
						$nom_area2=$row312[1];

						/*NOMES MOSTRA AULES AMB CAPACITAT <>0 -AIXI NO SURT EL CARRO-*/
						$sql32="SELECT * FROM mdl_block_mrbs_room WHERE area_id='$area2' and capacity<>'0' ORDER BY room_name";
						$result32=mysql_query($sql32, $conexion);
						while($row32=mysql_fetch_row($result32)){

							$compta_alumnes2=$compta_alumnes2+1;
							$nom_sala2=$row32[2];
							$nom_sala22=$row32[3];
							$ID_aula2=$row32[0];

							echo "<option value='$ID_aula2'>$nom_area2> $nom_sala2 ($nom_sala22)</option>";
						}
					}

		echo "</select><br>";

echo <<< HTML
<font face='Arial' size='2' color='black'><br>
11. Des de: <input name="data12" id="data12" type="text" size="7"><a href="javascript:NewCal('data12','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>
Fins a: <input name="data22" id="data22" type="text" size="7"><a href="javascript:NewCal('data22','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a></font>
HTML;

		echo "<br><br><input value='12. Confirma edició' type='submit'></form>

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

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></font></body></html>