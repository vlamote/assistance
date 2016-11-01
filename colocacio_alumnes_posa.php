<html><head><title>COL.AL.</title><head></head>
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="2"><a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_propis_llistat.php" title="Llista les col.locacions d'aules meves">Meus</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_llistat.php" title="Llista totes les col.locacions d'aules">Tots</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_crea_formulari.php" title="Crea la teva propia col.locacio d'alumnes">Crea</a></font></p></td>
<td width="65%"><p align="right"><font face="Verdana" size="2" color="red" style="BACKGROUND-COLOR: white">Pica als botons de cada cel·la per a modificar-la</font></p></td>
<td width="30%"><p align="right"><font face="Verdana" size="2"><b>Col:locacio dels ALumnes (COL.AL.)</b></font></p></td></tr>
</table><hr>
<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Usuaris.php";
echo "
<form method='POST' align='center' action='colocacio_alumnes_posa_confirma.php?registre=$registre&cela=$cela&id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula'>
	<select  name='id_alumne' class='select'>
		<option value=''>Tria alumne</option>";
		$sql31 = "SELECT * FROM mdl_groups_members WHERE (groupid='$id_grup')";
		$result31=mysql_query($sql31, $conexion);
		while($row31=mysql_fetch_row($result31)){
			$id_alumne=$row31[2];
			echo "<option value='$row31[2]'>".NomUsuari($id_alumne)."(".$id_alumne.")</option>";	
		}
echo "</select>
<br><br>
<input value='Confirma' type='submit'>
</form>";
include "desconnectaBD.php";
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></body></html>