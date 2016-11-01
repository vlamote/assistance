<html><head><title>COL.AL.</title><head></head>
<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#colocacions").tablesorter({
sortList: [[0,0],[1,0]]});});
</script></head><body bgcolor="#FFFFFF">
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="2"><a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_propis_llistat.php" title="Llista les col.locacions d'aules meves">Meus</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_llistat.php" title="Llista totes les col.locacions d'aules">Tots</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_crea_formulari.php" title="Crea la teva propia col.locacio d'alumnes">Crea</a></font></p></td>
<td width="65%"><p align="center"><font face="Verdana" size="2" color="red" style="BACKGROUND-COLOR: white">Pasa al ratoli sobre els LED per veure el nom del alumne. Pica per detall</font></p></td>
<td width="30%"><p align="right"><font face="Verdana" size="2"><b>Col.locacio dels ALumnes (COL.AL.)</b></font></p></td></tr>
</table><hr>
<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Usuaris.php";include "Funcions_Aules.php";

$id = $_POST["id"];
$comptador_cursos=0;
$comptador_alumnes=0;
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

		echo "<div align='center'><table id='colocacions' class='tablesorter' width='400px'>";
		echo"<thead>";
			echo"<tr>";
				echo"<th width='100px' align='center'>Aula</th>";
				echo"<th width='100px' align='center'>Grup</th>";
				echo"<th width='100px' align='center'>Profe</th>";
				echo"<th width='150px' align='center'>Alumnes</th>";
				echo"<th width='050px' align='center'>Accions</th>";
			echo"</tr>";
		echo"</thead>";

		$sql2="SELECT * FROM mdl_zzz_aules";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){

			$id_aula=$row2[1];
			$id_profe=$row2[2];
			$id_grup=$row2[3];

				echo"<tr>";                            
				echo"<td align='center' width='050px'><font face='Verdana' size='1'>".NomAula($id_aula)."</font></td>";
				echo"<td align='center' width='050px'><font face='Verdana' size='1'>".NomGrup($id_grup)."</font></td>";
					echo"<td align='center' width='100px'><font face='Verdana' size='1'>".NomUsuari($id_profe)."</font></td>";
					echo "<td align='center' width='150px'><font face='Verdana' size='1'>";
						$filera=6;
						for($filera==6;$filera>=1;$filera--){
							$columna=1;
							for($columna==1;$columna<=9;$columna++){
								$indise=(9*($filera-1)+($columna+3));
								if ($row2[$indise]==-1) {
									$acronim="M";
								}
								else{
									if ($row2[$indise]==0) {
										$acronim="U";
									}
									else {
										$acronim="S";
									}
								}
								$LED="imatges/LED_incidencia_".$acronim.".gif";
								echo "<a href=colocacio_alumnes.php?id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula title='".NomUsuari($row2[$indise])."'><img src='".$LED."'></a>";
							}
							echo "<br>";
						}
					echo "</font></td>";
					echo "<td align='center' width='050px'><font face='Verdana' size='1'>";
					echo "<a href=colocacio_alumnes.php?id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula title='Detalls col.locacio'><img src='imatges/LED_incidencia_E.gif'></a>";
					echo " ";
					echo "<a href=colocacio_alumnes_elimina.php?id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula title='Esborra col.locacio'><img src='imatges/LED_incidencia_J.gif'></a>";
					echo "</font></td></tr>";

					$comptador_alumnes=$comptador_alumnes+1;
		}
		echo "</table>";
		echo "<font face='Verdana' size='1'>".$comptador_alumnes." colocacions"."</font>";include "desconnectaBD.php";
	}
	else{
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></font></body></html>