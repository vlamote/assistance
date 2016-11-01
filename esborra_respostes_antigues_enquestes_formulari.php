<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8"><title>IN.T.E.RES.ANT.E.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="28%"><font face="Verdana" size="1" color="black">IN.T.E.RES.ANT.E.<p align="left">
<td width="54%"><font face="Verdana" size="1" color="red"><p align="center"><b>Recorda que s'esborraran totes les respostes A TOTS ELS CURSOS on està mapejada l'enquesta que triïs !!</b></p></td>
<td width="18%"><font face="Verdana" size="1" color="black"><p align="right"><b>INstantani i Total Esborrat de RESpostes ANTeriors d'Enquestes</b></p></font></td>
</tr></table><hr>

<?php

include "connectaBD.php";mysql_query("SET NAMES 'utf8'");include "PassaVars.php";include "Funcions_Temporals.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;

//SI NO ESTA LOGEJAT
if(!isloggedin()){

	header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }

//SI SI
else {

	//SI l'USUARI ES ADMIN
	if ($userid==7 OR $userid==2848){
	/***************************************************************************************************/

		//TRIA ENQUESTA
		echo "<table  style='text-align: left margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'><tbody>
			<tr align='center'>
				<td width='100%'>";
					echo "<form method='POST' action='esborra_respostes_antigues_enquestes_llistat.php'>";
						echo "<select  name='id_enquesta' class='select'>";
							echo "<option value=''>1. Tria enquesta</option>";
								$sql1="SELECT * FROM mdl_feedback ORDER BY name ASC";
								$result1=mysql_query($sql1, $conexion);
								while($row1=mysql_fetch_row($result1)){
									$nom_enquesta=$row1[2];
									echo "<option value='$row1[0]'>$nom_enquesta</option>";
								}
						echo "</select>";
						echo "<br><br>";
						echo "<input value='2. Neteja respostes A TOTS ELS CURSOS on està mapejada aquesta enquesta' type='submit'>";
					echo "</form>
				</td>
			</tr>
		</tbody></table>";

		include "desconnectaBD.php";

	/*******************CONTROL DE ACCES FINAL********************************************************/
	}
	else{
	
		echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}
/******************************************************************************************************/
?>
<hr><p align="center"><font face="Verdana" size="1" color="black">(c) V.L.G.A. 2015</font></p></font></body></html>