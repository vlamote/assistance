<html><head><title>COL.AL.</title><head></head>
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="2"><a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_llistat.php" title="Llista totes les col.locacions d'aules">Llistat</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_crea_formulari.php" title="Crea la teva propia col.locacio d'alumnes">Crea</a></font></p></td>
<td width="65%"><p align="right"><font face="Verdana" size="2" color="red" style="BACKGROUND-COLOR: white">Pica als botons de cada cel.la per a modificar-la</font></p></td>
<td width="30%"><p align="right"><font face="Verdana" size="2"><b>Col:locacio dels ALumnes (COL.AL.)</b></font></p></td></tr>
</table><hr>

<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Usuaris.php";include "sessionlib.php";include "Funcions_Aules.php";

$id = $_POST["id"];
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
	if (($userid == 7) OR (($userid <> 1) AND ($idprofe <> 0))){
		$nom_profe=NomUsuari($id_profe);
		$nom_aula=NomAula($id_aula);
		$nom_grup=NomGrup($id_grup);
		/*********************************************************/
		/*MIRO SI JA EXISTEIX ALGUN REGISTRE A MDL_ZZZ_AULES*/
		/*PER A AQUELL PROFESSOR, GRUP I AULA                                 */
		/*******************************************************/
		$existeix_sessio=0;
		$sql00 = "SELECT * FROM mdl_zzz_aules WHERE  (id_profe= '$id_profe' AND id_aula= '$id_aula' AND id_grup= '$id_grup')";
		$result00=mysql_query($sql00, $conexion);
			if(($row00=mysql_fetch_row($result00) AND ($userid==$id_profe)) OR ($userid=='7')){
				$sql11 = "DELETE FROM mdl_zzz_aules WHERE  (id_profe= '$id_profe' AND id_aula= '$id_aula' AND id_grup= '$id_grup')";
				$result11=mysql_query($sql11,$conexion);
				header("Location: colocacio_alumnes_llistat.php");
				exit();
			}
			else{
				echo "<p align='center'><font face='Verdana' size='2' color='red'>No hi ha cap col.locacio creada amb el professor <b>".$nom_profe."</b> i el grup <b>".$nom_grup."</b> a l'aula <b>".$nom_aula."</b> Pica <a href='colocacio_alumnes_crea_formulari.php?id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula'>aqui</a> per crear-ne alguna</b></font></p>";
			}
		}
	else{
			echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></body></html>