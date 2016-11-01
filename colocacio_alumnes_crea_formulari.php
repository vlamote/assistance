<html><head><title>COL.AL.</title><head></head>
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="2"><a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_propis_llistat.php" title="Llista les col.locacions d'aules meves">Meus</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_llistat.php" title="Llista totes les col.locacions d'aules">Tots</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_crea_formulari.php" title="Crea la teva propia col.locacio d'alumnes">Crea</a></font></p></td>
<td width="65%"><p align="center"><font face="Verdana" size="2" color="red" style="BACKGROUND-COLOR: white">Tria grup, aula i prem el boto</font></p></td>
<td width="30%"><p align="right"><font face="Verdana" size="2"><b>Col.locacio dels ALumnes (COL.AL.)</b></font></p></td></tr>
</table><hr>

<?php
	include "connectaBD.php";include "PassaVars.php";include "Funcions_Usuaris.php";include "sessionlib.php";include "Funcions_Aules.php";
	require_once ('../config.php');
	global $USER;
	$userid=$USER->id;
	if(!isloggedin()){
		header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }
	else {
		$idprofe=0;
		$sql2 = "SELECT * FROM mdl_cohort_members WHERE ((userid='$userid') AND ((cohortid=43) OR (cohortid=44) OR (cohortid=45) OR (cohortid=59)))";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){
			$idprofe=$row2[0];
		}

		if (($userid==7) OR (($userid <> 1) AND ($idprofe <> 0))){

			$alumnes=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
			$nom_alumnes=array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
			$alumnescolocats=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);		

			echo "<p align='center'>Col.locacio automatica d'alumnes generada per <b>".NomUsuari($userid)." (".$userid.")"."</b></p>";
			$id_profe=$userid;

			/*LLISTA GRUPS PROFESSOR*/
			
			echo "<table align='center'><tr><td>
						<form name =\"triaassistencia\" action=\"".$_SERVER['PHP_SELF']."\" method=\"POST\">\n\n";
						echo"
						<p align='left'>
						<select name=\"id1\" class='select' onChange=\"this.form.submit()\">\n";
						echo "<option value=''>1. Tria materia (*)</option>";

						/*PERQUE HI HA REGISTRES REPETITS, NO SE PERQUE*/
						$contexte_anterior=0;

						/*BUSCA TOTS ELS ASSIGNAMENTS ON L'USUARI ES PROFESSOR: (ROLE=3) */
						$sql2="SELECT * FROM mdl_role_assignments WHERE roleid='3' AND userid='$userid' ORDER BY contextid ASC";
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
	
		echo "</select>";
echo "</form>";

echo "
<form method='POST' action='colocacio_alumnes_crea_llistat.php?id_profe=$id_profe'>
<p align='left'>
	<select  name='id_grup' class='select' >
		<option value=''>2. Tria grup (*)</option>";

		/*ESBRINO GRUPS DEL CURS*/
		$sql32 = "SELECT * FROM mdl_groups WHERE (courseid='$id1') ORDER BY name ASC";
		$result32=mysql_query($sql32, $conexion);
		while($row32=mysql_fetch_row($result32)){

			$id_grup=$row32[0];
			$nom_grup=$row32[3];
			echo "<option value='$id_grup'>$nom_grup</option>";
		}

echo "</select>";

			/*LLISTA AULES*/
			echo "
			<form method='POST' action='colocacio_alumnes_auto.php'>
			<br><p align='left'>
			<select  name='id_aula' class='select' >
				<option value=''>3. Tria aula (*)</option>";
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
						$id_aula=$row3[0];

						echo "<option value='$id_aula'>$nom_area > $nom_sala ($nom_sala2)</option>";
					}
				}

			echo "</select>
			<br><br><input value='4. Confirma creacio' type='submit'></form></td></tr></table>";

			$id_grup=$_POST["id_grup"];
			$id_aula=$_POST["id_aula"];

			include "desconnectaBD.php";
		}
		else{
			echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
		}
	}
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></body></html>