<html><head><title>COL.AL.</title><head></head>
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="2"><a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_propis_llistat.php" title="Llista les col.locacions d'aules meves">Meus</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_llistat.php" title="Llista totes les col.locacions d'aules">Tots</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_crea_formulari.php" title="Crea la teva propia col.locacio d'alumnes">Crea</a></font></p></td>
<td width="65%"><p align="right"><font face="Verdana" size="2" color="red" style="BACKGROUND-COLOR: white">Pica als botons de cada cel.la per a modificar-la</font></p></td>
<td width="30%"><p align="right"><font face="Verdana" size="2"><b>Col:locacio dels ALumnes (COL.AL.)</b></font></p></td></tr>
</table><hr>
<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Usuaris.php";include "sessionlib.php";include "Funcions_Aules.php";
CreaColocacioAlumnes($id_profe,$id_aula,$id_grup);
header("Location: colocacio_alumnes.php?id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula");
exit()
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></body></html>