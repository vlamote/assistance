<html><head><title>TROBA.P.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b><a href="/assistencia/troba_profe_formulari.php">Troba'n més</a></b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>Horari del professor</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>TROBA.P.</b></p></font></td>
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
		$idalumne= $userid;
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
		$color_data=0;
		$factordecolor=65525;

		/*SEGONS EL DIA DE LA SETMANA TRIAT AGAFARE UNS DIES ABANS O DESPRES PER A CREAR LA SETMANA*/
		$dia_setmana=date("l",$dataentrada1);

		if($dia_setmana=="Monday"){
			$dia= $dataentrada1+0*(24*3600);
		}

		if($dia_setmana=="Tuesday"){
			$dia= $dataentrada1+0*(24*3600);
		}

		if($dia_setmana=="Wednesday"){
			$dia= $dataentrada1+0*(24*3600);
		}

		if($dia_setmana=="Thursday"){
			$dia= $dataentrada1+0*(24*3600);
		}

		if($dia_setmana=="Friday"){
			$dia= $dataentrada1+0*(24*3600);
		}

		if($dia_setmana=="Saturday"){
			$dia_1= $dataentrada1+2*(24*3600);
			$dia_2= $dataentrada1+3*(24*3600);
			$dia_3=$dataentrada1+4*(24*3600);
			$dia_4= $dataentrada1+5*(24*3600);
			$dia_5= $dataentrada1+6*(24*3600);
		}

		if($dia_setmana=="Sunday"){
			$dia_1= $dataentrada1+1*(24*3600);
			$dia_2= $dataentrada1+2*(24*3600);
			$dia_3=$dataentrada1+3*(24*3600);
			$dia_4= $dataentrada1+4*(24*3600);
			$dia_5= $dataentrada1+5*(24*3600);
		}

$dia_1=$dia+14*3600;

$dia_11=date("d/m/y",$dia_1);

		/*ESBRINO NOM PROFE*/
		$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){
	
			$alumne=$row2[11].", ".$row2[10];
	
			echo "<p align='center'><b><font face='Verdana' size='2'>Horari de:</b> $alumne ($idalumne)<b> en data:</b> $data1_amb_dia_setmana<br></font></p>";
		}

/* ENCAPSALAMENT DE LA TAULA */
echo"
<div align='center'>
        <table id='horari' width='600px' class='tablesorter' border='1'>
        <thead>
            <tr>
            <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Hora</th>
            <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Materia</th>
            <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Detalls</th>
            </tr>
        </thead>
</div>";

		/*DILLUNS*/

		echo"<td width='300px' align='center'>";

		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dia') AND (sessdate<='$dia_1')) AND (description LIKE '%$alumne%') ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/

			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("h:i a", $hora_sessio);
			$grup=$row5[2];
			$assistencia=$row5[1];
			$detalls=$row5[8];

				/*BUSCO ASSISTENCIA DE CADA SESSIO. POT HAVER MES D'UNA*/
				$sql4 = "SELECT * FROM mdl_attforblock WHERE (id='$assistencia')";
				$result4=mysql_query($sql4, $conexion);
				while($row4=mysql_fetch_row($result4)){/*WHILE3*/
				
					$ID_curs=$row4[1];

					/*COLOR CEL.LA*/
					/*$color_curs="#".dechex($ID_curs*$factordecolor);*/

					/*TRANSFORMO ID EN CARACTERS*/
					$ID_curs_String=strval($ID_curs);

					/*AGAFO EL PRIMER CARACTER*/
					$Unitats = substr($ID_curs_String,-1);

					/*SEGONS EL NUMERO 0, ... ,9 AJUSTO UN COLOR*/
/*LILA*/			if ($Unitats==0){$color_curs="#D698E7";}
/*BLAUET*/		if ($Unitats==1){$color_curs="#98A9E7";}
/*BLAU CLAR*/	if ($Unitats==2){$color_curs="#98D9E7";}
/*VERD CLAR*/	if ($Unitats==3){$color_curs="#49F28D";}
/*GROGUET*/		if ($Unitats==4){$color_curs="#D9E798";}
/*SEPIA*/			if ($Unitats==5){$color_curs="#E7C598";}
/*ROGET*/		if ($Unitats==6){$color_curs="#EAAD34";}
/*GROC*/			if ($Unitats==7){$color_curs="#EAE734";}
/*VERD*/			if ($Unitats==8){$color_curs="#43EA34";}
/*BLAU*/			if ($Unitats==9){$color_curs="#34B0EA";}

					/*TRANSFORMO CURS EN CONTEXT*/
					$sql2 = "SELECT * FROM mdl_context WHERE (instanceid='$ID_curs')";
					$result2=mysql_query($sql2, $conexion);
					while($row2=mysql_fetch_row($result2)){
		
						$contexte=$row2[0];
					}

					/*ESBRINO NOM DEL CURS*/
					$sql3 = "SELECT * FROM mdl_course WHERE (id='$ID_curs')";
					$result3=mysql_query($sql3, $conexion);
					while($row3=mysql_fetch_row($result3)){
		
						$curs=$row3[4];

						$sql61 = "SELECT * FROM mdl_course_modules WHERE (course='$ID_curs' AND instance='$assistencia' AND (showavailability='0' OR showavailability='1'))";
						$result61=mysql_query($sql61, $conexion);
						while($row61=mysql_fetch_row($result61)){

							$enllas="http://iessitges.xtec.cat/mod/attforblock/take.php?id=".$row61[0]."&sessionid=".$ID_sessio."&grouptype=".$grup;
							$enllas2="http://iessitges.xtec.cat/course/view.php?id=".$ID_curs;
							$enllas3="http://iessitges.xtec.cat/grade/report/grader/index.php?id=".$ID_curs;
						}


						if($colorfons=="#FFFFFF"){
							$colorfons="#FFFFEE";
						}
						else{
							$colorfons="#FFFFFF";
						}

echo"
<tr>
<td width='200px' bgcolor='$colorfons'><font face='Verdana' size='1'><p align='center'><a href='$enllas' title='Passa llista' target='blank'>$hora_sessio1</a> </p></font></td>
<td width='200px' bgcolor='$colorfons'><font face='Verdana' size='1'><p align='center'><a href='$enllas2' title='Entra al curs' target='blank'>$curs</a>
<a href='$enllas3' title='Qualifica' target='blank'><img src='http://iessitges.xtec.cat/assistencia/imatges/nota.svg'></a></p></font></td>
<td width='200px' bgcolor='$colorfons'><font face='Verdana' size='1'><p align='center'>$detalls</p></font></td>
</tr>
";
					}
				}/*FI WHILE3*/
		}/*FI WHILE1*/

		echo"</td>";

echo"</td></tr></table>";

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