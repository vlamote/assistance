<html><head><title>TROB.AL.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b><a href="/assistencia/troba_alum_formulari.php">Troba'n m�s</a></b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>Horari d'alumne</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>TROBa ALumnes</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;

if(!isloggedin()){
		
	header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); 
}
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
		
	if ((($userid <> 1) AND ($idprofe <> 0)) OR ($userid==7)){

/**************************************************************************************************/

		/*VARIABLES*/
		$idalumne= $_POST["idalumne"];
		$ara=time();
		$dia_ara=date("d",$ara);
		$mes_ara=date("m",$ara);
		$any_ara=date("y",$ara);
		$ara=mktime(8,0,0,$mes_ara,$dia_ara,$any_ara);
		$dataentrada1 = $ara;
		$dataentrada2 = $ara+14*3600;
		$data1_amb_dia_setmana=date("l d/m/y",$dataentrada1);
		$data2_amb_dia_setmana=date("l d/m/y",$dataentrada2);
		$colorfons="#FFFFFF";

		/*ESBRINO NOM ALUMNE*/
		$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){
	
			$alumne=$row2[11].", ".$row2[10];
			$nom_alumne=$row2[11].", ".$row2[10];
	
			echo "<p align='center'><b><font face='Verdana' size='1'>Horari de:</b> $alumne ($idalumne)<b> en data:</b> $data1_amb_dia_setmana<br></font></p>";
		}
	

		/*CAP�ALERA*/
		echo "<div align='center'>
		<table id='Incidencies' class='tablesorter' width='800px' border='1'1>
		<thead>
		<tr>
		<th width='200px' align='center'><b><font face='Verdana' size='1'>Hora</font></b></th>
		<th width='200px' align='center'><b><font face='Verdana' size='1'>Mat�ria</font></b></th>
		<th width='400px' align='center'><b><font face='Verdana' size='1'>Detalls</font></b></th>
		</tr>
		</thead>
		</div>";

		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dataentrada1') AND (sessdate<='$dataentrada2')) ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/
				
			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("h:i a", $hora_sessio);
			$grup=$row5[2];
			$assistencia=$row5[1];
			$detalls=$row5[8];

			/*BUSCO QUINES SESSIONS TENEN GRUPS ON ESTA L'ALUMNE*/
			$sql115 = "SELECT * FROM mdl_groups_members WHERE ((userid='$idalumne') AND (groupid='$grup'))";
			$result115=mysql_query($sql115, $conexion);
			if ($row115=mysql_fetch_row($result115)){/*IF2*/
				
				/*BUSCO ASSISTENCIA DE CADA SESSIO. POT HAVER MES D'UNA*/
				$sql4 = "SELECT * FROM mdl_attforblock WHERE (id='$assistencia')";
				$result4=mysql_query($sql4, $conexion);
				while($row4=mysql_fetch_row($result4)){/*WHILE3*/
				
					$ID_curs=$row4[1];

					/*ESBRINO NOM DEL CURS*/
					$sql3 = "SELECT * FROM mdl_course WHERE (id='$ID_curs')";
					$result3=mysql_query($sql3, $conexion);
					while($row3=mysql_fetch_row($result3)){
		
						$curs=$row3[4];

$detall_curs=$row3[3];
$sql61 = "SELECT * FROM mdl_course_modules WHERE (course='$ID_curs' AND instance='$assistencia' AND (showavailability='0' OR showavailability='1'))";
$result61=mysql_query($sql61, $conexion);
while($row61=mysql_fetch_row($result61)){
	$enllas="http://iessitges.xtec.cat/mod/attforblock/take.php?id=".$row61[0]."&sessionid=".$ID_sessio."&grouptype=".$grup;
	$enllas2="http://iessitges.xtec.cat/course/view.php?id=".$ID_curs;
}

						if($colorfons=="#FFFFFF"){
							$colorfons="#FFFFEE";
						}
						else{
							$colorfons="#FFFFFF";
						}

						echo"
						<td align='left' width='200px' bgcolor='$colorfons'><font face='Verdana' size='1'><a href='$enllas' title='Passa llista' target='blank'>$hora_sessio1</a></font></td>
						<td align='left' width='200px' bgcolor='$colorfons'><font face='Verdana' size='1'>$curs</font></td>
						<td align='left' width='400px' bgcolor='$colorfons'><font face='Verdana' size='1'>$detalls</font></td>
						</tr>";
					}
				}/*FI WHILE3*/
			}/*FI IF2*/
		}/*FI WHILE1*/

		echo "</tbody>";
		echo "</table>";

		include "desconnectaBD.php";

/*******************CONTROL D'ACCES FINAL********************************************************/

	}
	else{
			echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
	}
}

/******************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></body></html>