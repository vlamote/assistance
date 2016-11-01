<html><head><meta http-equiv="Content-type" content="text/html; charset=utf-8"><title>IN.T.E.RES.ANT.E.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="28%"><font face="Verdana" size="1" color="black">IN.T.E.RES.ANT.E.<p align="left">
<td width="54%"><font face="Verdana" size="1" color="red"><p align="center"><b>Tria l'enquesta de la qual vols netejar les respostes</b></p></td>
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

		//ESBORRO TOTES LES COMPLECIONS DE L'ENQUESTA AMB ID=ID_ENQUESTA A LA TAULA MDL_FEEDBACK_COMPLETED
		$sql0 = "DELETE FROM mdl_feedback_completed WHERE (feedback='$id_enquesta')";
		$result0=mysql_query($sql0, $conexion);
		while($row0=mysql_fetch_row($result0)){
			$id0=$row0[0];
		}
		echo "1. Esborrades respostes completades enquesta ".$id_enquesta."<br>";

		//ESBORRO TOTES LES COMPLECIONS DE L'ENQUESTA AMB ID=ID_ENQUESTA A LA TAULA MDL_FEEDBACK_COMPLETEDTMP
		$sql1 = "DELETE FROM mdl_feedback_completedtmp WHERE (feedback='$id_enquesta')";
		$result1=mysql_query($sql1, $conexion);
		while($row1=mysql_fetch_row($result1)){
			$id1=$row1[0];
		}
		echo "2. Esborrades respostes completades temporalment enquesta ".$id_enquesta."<br>";

		//ESBORRO TOTES LES COMPLECIONS DE L'ENQUESTA AMB ID=ID_ENQUESTA A LA TAULA MDL_FEEDBACK_TRACKING
		$sql2 = "DELETE FROM mdl_feedback_tracking WHERE (feedback='$id_enquesta')";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){
			$id2=$row2[0];
		}
		echo "3. Esborrades respostes seguides enquesta ".$id_enquesta."<br>";

		//ESBRINO LES COMPLECIONS DE L'ENQUESTA AMB ID=ID_ENQUESTA A LA TAULA MDL_FEEDBACK_ITEM
		$sql3 = "SELECT * FROM mdl_feedback_item WHERE (feedback='$id_enquesta')";
		$result3=mysql_query($sql3, $conexion);
		while($row3=mysql_fetch_row($result3)){
			$id3=$row3[0];	
			//ESBORRO TOTES LES COMPLECIONS DE CADA ITEM AMB ID=ID_ITEM A LA TAULA MDL_FEEDBACK_VALUE
			$sql4 = "DELETE FROM mdl_feedback_value WHERE (item='$id3')";
			$result4=mysql_query($sql4, $conexion);
			while($row4=mysql_fetch_row($result4)){
				$id4=$row4[0];
			}
		}
		echo "3. Esborrades respostes items enquesta ".$id_enquesta."<br>";

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