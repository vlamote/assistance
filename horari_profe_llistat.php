<html><head><title>HORA.P.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b><a href="/assistencia/horari_profe_formulari.php">Troba'n més</a></b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>Pica:<br>A l'hora per passar llista.<br>Al curs per a anar-hi.<br>Al grup per a veure'l.<br>A l'aula per a veure la reserva.<br>Al professor per a veure el perfil</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>HORAri de Professor</b></p></font></td>
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
		
		$alumne=$row2[11].", ".$row2[10];
		$idprofe=$row2[0];
	}
		
	if ((($userid <> 1) AND ($idprofe <> 0)) OR ($userid==7)){

/**************************************************************************************************/

		/*VARIABLES*/

		$idalumne = $_POST["idalumne"];
		$data1= $_POST["data1"];
		$observacions= $_POST["observacions"];
		$observacions=str_replace("'","`",$observacions);
		$dataentrada1 = strtotime($data1)+7*3600;
		$dataentrada2 = strtotime($data1)+22*3600;
		$dataentrada11=date("d/m/y h:i a", $dataentrada1);
		$dataentrada21=date("d/m/y h:i a", $dataentrada2);
		$ara=time();
		$dataara=date("d/m/y h:i a",$ara);
		$data1_amb_dia_setmana=date("l d/m/y",$dataentrada1);

		/*SEGONS EL DIA DE LA SETMANA TRIAT AGAFARE UNS DIES ABANS O DESPRES PER A CREAR LA SETMANA*/
		$dia_setmana=date("l",$dataentrada1);

		if($dia_setmana=="Monday"){
			$dia_1= $dataentrada1+0*(24*3600);
			$dia_2= $dataentrada1+1*(24*3600);
			$dia_3= $dataentrada1+2*(24*3600);
			$dia_4= $dataentrada1+3*(24*3600);
			$dia_5= $dataentrada1+4*(24*3600);
		}

		if($dia_setmana=="Tuesday"){
			$dia_1= $dataentrada1-1*(24*3600);
			$dia_2= $dataentrada1+0*(24*3600);
			$dia_3= $dataentrada1+1*(24*3600);
			$dia_4= $dataentrada1+2*(24*3600);
			$dia_5= $dataentrada1+3*(24*3600);
		}

		if($dia_setmana=="Wednesday"){
			$dia_1= $dataentrada1-2*(24*3600);
			$dia_2= $dataentrada1-1*(24*3600);
			$dia_3= $dataentrada1+0*(24*3600);
			$dia_4= $dataentrada1+1*(24*3600);
			$dia_5= $dataentrada1+2*(24*3600);
		}

		if($dia_setmana=="Thursday"){
			$dia_1=$dataentrada1-3*(24*3600);
			$dia_2= $dataentrada1-2*(24*3600);
			$dia_3= $dataentrada1-1*(24*3600);
			$dia_4= $dataentrada1+0*(24*3600);
			$dia_5= $dataentrada1+1*(24*3600);
		}

		if($dia_setmana=="Friday"){
			$dia_1= $dataentrada1-4*(24*3600);
			$dia_2= $dataentrada1-3*(24*3600);
			$dia_3= $dataentrada1-2*(24*3600);
			$dia_4= $dataentrada1-1*(24*3600);
			$dia_5= $dataentrada1+0*(24*3600);
		}

		if($dia_setmana=="Saturday"){
			$dia_1= $dataentrada1+2*(24*3600);
			$dia_2= $dataentrada1+3*(24*3600);
			$dia_3= $dataentrada1+4*(24*3600);
			$dia_4= $dataentrada1+5*(24*3600);
			$dia_5= $dataentrada1+6*(24*3600);
		}

		if($dia_setmana=="Sunday"){
			$dia_1= $dataentrada1+1*(24*3600);
			$dia_2= $dataentrada1+2*(24*3600);
			$dia_3= $dataentrada1+3*(24*3600);
			$dia_4= $dataentrada1+4*(24*3600);
			$dia_5= $dataentrada1+5*(24*3600);
		}

		$dia_11=$dia_1+14*3600;
		$dia_21=$dia_2+14*3600;
		$dia_31=$dia_3+14*3600;
		$dia_41=$dia_4+14*3600;
		$dia_51=$dia_5+14*3600;

		$dia111=date("d/m/y",$dia_1);
		$dia211=date("d/m/y",$dia_2);
		$dia311=date("d/m/y",$dia_3);
		$dia411=date("d/m/y",$dia_4);
		$dia511=date("d/m/y",$dia_5);

		/*ESBRINO NOM PROFE*/
		$sql2 = "SELECT * FROM mdl_user WHERE id=$idalumne";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){
	
			$alumne=$row2[11].", ".$row2[10];
	
			echo "<p align='center'><b><font face='Verdana' size='2'>Horari de:</b> $alumne ($idalumne)<b> en data:</b> $data1_amb_dia_setmana<br></font></p>";
		}

		/* ENCAPSALAMENT DE LA TAULA */
		echo "<p align='center'><font face='Verdana' size='2' color='red'>És possible que alguna sessió a prop de canvis horaris d'estiu o hivern (finals d'octubre i/o finals de març)<br><b>tinguin algun desfassament horari</b> degut a que cada any aquestes dates són diferents.<br>El sistema considera el canvi horari el 01/04 i el 01/11!</p>
		<div align='center'>
	        	<table id='horari' width='1500px' class='tablesorter'  border='1' bgcolor='#CACAC0'>
	        	<thead>
		        <tr>
			        <th width='300px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dilluns $dia111</th>
			        <th width='300px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dimarts $dia211</font></th>
				<th width='300px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dimecres $dia311</font></th>
			        <th width='300px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dijous $dia411</font></th>
			       <th width='300px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Divendres $dia511</font></th>
			</tr>
			</thead>
		</div>";

		/*DILLUNS*/

		echo"<td width='300px' align='center'>";

		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dia_1') AND (sessdate<='$dia_11')) AND (description LIKE '%$alumne%') ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/

			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("h:i a", $hora_sessio);
			$durada=$row5[4];
			$hora_sessio2=date("h:i a", $hora_sessio+$durada);
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
						$nom_curs_llarg=$row3[3];

						$sql61 = "SELECT * FROM mdl_course_modules WHERE (course='$ID_curs' AND instance='$assistencia' AND (showavailability='0' OR showavailability='1'))";
						$result61=mysql_query($sql61, $conexion);
						while($row61=mysql_fetch_row($result61)){

							$enllas="http://iessitges.xtec.cat/mod/attforblock/take.php?id=".$row61[0]."&sessionid=".$ID_sessio."&grouptype=".$grup;
							$enllas2="http://iessitges.xtec.cat/course/view.php?id=".$ID_curs;
						}

						echo"
<table bgcolor='$color_curs' border='1px'>
<tr>
<td width='300px'>
<font face='Verdana' size='1'><p align='center'>
<a href='$enllas' title='Passa llista' target='blank'>Hora: $hora_sessio1 - $hora_sessio2</a><br><br>
<a href='$enllas2' title='Entra al curs $nom_curs_llarg' target='blank'>Curs: $curs</a>
$detalls</p></font>
</td>
</tr>
</table>";
					}
				}/*FI WHILE3*/
		}/*FI WHILE1*/


		echo"</td>";

		/*DIMARTS*/

		echo"<td width='300px' align='center'>";

		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dia_2') AND (sessdate<='$dia_21')) AND (description LIKE '%$alumne%') ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/
				
			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("h:i a", $hora_sessio);
			$durada=$row5[4];
			$hora_sessio2=date("h:i a", $hora_sessio+$durada);
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
						$nom_curs_llarg=$row3[3];

						$sql61 = "SELECT * FROM mdl_course_modules WHERE (course='$ID_curs' AND instance='$assistencia' AND (showavailability='0' OR showavailability='1'))";
						$result61=mysql_query($sql61, $conexion);
						while($row61=mysql_fetch_row($result61)){

							$enllas="http://iessitges.xtec.cat/mod/attforblock/take.php?id=".$row61[0]."&sessionid=".$ID_sessio."&grouptype=".$grup;
							$enllas2="http://iessitges.xtec.cat/course/view.php?id=".$ID_curs;
						}

						echo"
<table bgcolor='$color_curs' border='1px'>
<tr>
<td width='300px'>
<font face='Verdana' size='1'><p align='center'>
<a href='$enllas' title='Passa llista' target='blank'>Hora: $hora_sessio1 - $hora_sessio2</a><br><br>
<a href='$enllas2' title='Entra al curs $nom_curs_llarg' target='blank'>Curs: $curs</a>
$detalls</p></font>
</td>
</tr>
</table>";					}
				}/*FI WHILE3*/
		}/*FI WHILE1*/

		echo"</td>";

		/*DIMECRES*/

		echo"<td width='300px' align='center'>";

		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dia_3') AND (sessdate<='$dia_31')) AND (description LIKE '%$alumne%') ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/
				
			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("h:i a", $hora_sessio);
			$durada=$row5[4];
			$hora_sessio2=date("h:i a", $hora_sessio+$durada);
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
						$nom_curs_llarg=$row3[3];

						$sql61 = "SELECT * FROM mdl_course_modules WHERE (course='$ID_curs' AND instance='$assistencia' AND (showavailability='0' OR showavailability='1'))";
						$result61=mysql_query($sql61, $conexion);
						while($row61=mysql_fetch_row($result61)){

							$enllas="http://iessitges.xtec.cat/mod/attforblock/take.php?id=".$row61[0]."&sessionid=".$ID_sessio."&grouptype=".$grup;
							$enllas2="http://iessitges.xtec.cat/course/view.php?id=".$ID_curs;
						}
						echo"
<table bgcolor='$color_curs' border='1px'>
<tr>
<td width='300px'>
<font face='Verdana' size='1'><p align='center'>
<a href='$enllas' title='Passa llista' target='blank'>Hora: $hora_sessio1 - $hora_sessio2</a><br><br>
<a href='$enllas2' title='Entra al curs $nom_curs_llarg' target='blank'>Curs: $curs</a>
$detalls</p></font>
</td>
</tr>
</table>";
					}
				}/*FI WHILE3*/
		}/*FI WHILE1*/

		echo"</td>";

		/*DIJOUS*/

		echo"<td width='300px' align='center'>";

		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dia_4') AND (sessdate<='$dia_41')) AND (description LIKE '%$alumne%') ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/
				
			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("h:i a", $hora_sessio);
			$durada=$row5[4];
			$hora_sessio2=date("h:i a", $hora_sessio+$durada);
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
						$nom_curs_llarg=$row3[3];

						$sql61 = "SELECT * FROM mdl_course_modules WHERE (course='$ID_curs' AND instance='$assistencia' AND (showavailability='0' OR showavailability='1'))";
						$result61=mysql_query($sql61, $conexion);
						while($row61=mysql_fetch_row($result61)){

							$enllas="http://iessitges.xtec.cat/mod/attforblock/take.php?id=".$row61[0]."&sessionid=".$ID_sessio."&grouptype=".$grup;
							$enllas2="http://iessitges.xtec.cat/course/view.php?id=".$ID_curs;
						}

						echo"
<table bgcolor='$color_curs' border='1px'>
<tr>
<td width='300px'>
<font face='Verdana' size='1'><p align='center'>
<a href='$enllas' title='Passa llista' target='blank'>Hora: $hora_sessio1 - $hora_sessio2</a><br><br>
<a href='$enllas2' title='Entra al curs $nom_curs_llarg' target='blank'>Curs: $curs</a>
$detalls</p></font>
</td>
</tr>
</table>";
					}
				}/*FI WHILE3*/
		}/*FI WHILE1*/

		echo"</td>";

		/*DIVENDRES*/

		echo"<td width='300px' align='center'>";
		
		/*BUSCO SESSIONS AL DIA DONAT D'AQUELLES ASSISTENCIES. POT HAVER MES D'UNA*/
		$sql5 = "SELECT * FROM mdl_attendance_sessions WHERE ((sessdate>='$dia_5') AND (sessdate<='$dia_51')) AND (description LIKE '%$alumne%') ORDER BY sessdate";
		$result5=mysql_query($sql5, $conexion);
		while($row5=mysql_fetch_row($result5)){/*WHILE1*/
				
			$ID_sessio=$row5[0];
			$hora_sessio=$row5[3];
			$hora_sessio1=date("h:i a", $hora_sessio);
			$durada=$row5[4];
			$hora_sessio2=date("h:i a", $hora_sessio+$durada);
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
						$nom_curs_llarg=$row3[3];

						$sql61 = "SELECT * FROM mdl_course_modules WHERE (course='$ID_curs' AND instance='$assistencia' AND (showavailability='0' OR showavailability='1'))";
						$result61=mysql_query($sql61, $conexion);
						while($row61=mysql_fetch_row($result61)){

							$enllas="http://iessitges.xtec.cat/mod/attforblock/take.php?id=".$row61[0]."&sessionid=".$ID_sessio."&grouptype=".$grup;
							$enllas2="http://iessitges.xtec.cat/course/view.php?id=".$ID_curs;
						}

						echo"
<table bgcolor='$color_curs' border='1px'>
<tr>
<td width='300px'>
<font face='Verdana' size='1'><p align='center'>
<a href='$enllas' title='Passa llista' target='blank'>Hora: $hora_sessio1 - $hora_sessio2</a><br><br>
<a href='$enllas2' title='Entra al curs $nom_curs_llarg' target='blank'>Curs: $curs</a>
$detalls</p></font>
</td>
</tr>
</table>";
					}
				}/*FI WHILE3*/
		$color_data=0;
		}/*FI WHILE1*/

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