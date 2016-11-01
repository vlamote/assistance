<html><head><title>RESA.</title></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b><a href="/assistencia/horari_aula_formulari.php">Troba'n mes</a></b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center">REServes d'Aula</p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>REServes d'Aula</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Temporals.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");

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

			$idaula = $_POST["idaula"];
			$data1= $_POST["data1"];
			$dataentrada1 = strtotime($data1)+7*3600;
			$dataentrada2 = strtotime($data1)+22*3600;
			$dataentrada11=date("d/m/y h:i a", $dataentrada1);
			$dataentrada21=date("d/m/y h:i a", $dataentrada2);
			$ara=time();
			$dataara=date("d/m/y h:i a",$ara);
			$data1_amb_dia_setmana=date("l d/m/y",$dataentrada1);
			$dia_setmana=date("l",$dataentrada1);

			/*ESBRINO NOM AULA*/

			$sql55 = "SELECT * FROM mdl_block_mrbs_room WHERE id='$idaula'";
			$result55=mysql_query($sql55, $conexion);
			while($row55=mysql_fetch_row($result55)){
				$nom_aula=$row55[2];
			}

			/*SEGONS EL DIA DE LA SETMANA TRIAT AGAFARE UNS DIES ABANS O DESPRES PER A CREAR LA SETMANA*/

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

			/*ESBRINO RESERVES*/

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl01="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl01="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl01="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl01="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl01="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl01="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl01="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl01="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl01="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl01="#34B0EA";}

				/*ESBRINO ELS MINUTS DE START_TIME*/
				/*PER A VEURE A QUINA HORA CORRESPON*/
				/*(EL PROGRAMA MRBS FUNCIONA AIXI)*/
				/*MINUT 00 -> HORA 01*/
				/*MINUT 01 -> HORA 02*/
				/*...*/
				/*MINUT 14 -> HORA 13*/
				/*MINUT 15 -> HORA 14*/

				$minutet=date("i", $hora_sessio);
				if ($minutet==0){$Dl01=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl02="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl02="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl02="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl02="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl02="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl02="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl02="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl02="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl02="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl02="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==1){$Dl02=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl03="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl03="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl03="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl03="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl03="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl03="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl03="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl03="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl03="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl03="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==2){$Dl03=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				if($profe==""){$profe="----";}
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl04="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl04="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl04="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl04="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl04="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl04="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl04="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl04="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl04="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl04="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==3){$Dl04=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl05="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl05="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl05="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl05="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl05="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl05="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl05="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl05="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl05="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl05="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==4){$Dl05=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl06="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl06="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl06="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl06="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl06="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl06="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl06="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl06="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl06="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl06="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==5){$Dl06=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl07="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl07="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl07="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl07="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl07="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl07="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl07="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl07="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl07="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl07="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==6){$Dl07=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl08="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl08="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl08="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl08="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl08="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl08="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl08="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl08="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl08="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl08="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==7){$Dl08=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl09="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl09="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl09="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl09="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl09="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl09="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl09="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl09="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl09="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl09="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==8){$Dl09=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl10="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl10="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl10="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl10="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl10="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl10="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl10="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl10="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl10="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl10="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==9){$Dl10=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl11="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl11="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl11="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl11="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl11="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl11="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl11="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl11="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl11="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl11="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==10){$Dl11=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl12="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl12="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl12="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl12="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl12="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl12="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl12="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl12="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl12="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl12="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==11){$Dl12=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl13="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl13="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl13="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl13="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl13="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl13="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl13="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl13="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl13="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl13="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==12){$Dl13=$profe;}
			}

			$sql5 = "SELECT * FROM mdl_block_mrbs_entry WHERE ((start_time>='$dia_1') AND (end_time<='$dia_11') AND (room_id='$idaula')) ORDER BY start_time";
			$result5=mysql_query($sql5, $conexion);
			while($row5=mysql_fetch_row($result5)){

				$ID_sessio=$row5[0];
				$hora_sessio=$row5[1];
				$hora_sessio1=date("d/m/y h:i a", $hora_sessio);
				$hora_sessio2=$row5[2];
				$hora_sessio3=date("h:i a", $hora_sessio2);
				$profe=$row5[8];
				$descripcio=$row5[10];
				$tipus=$row5[9];
				$auleta=$row5[5];

				/*SEGONS EL TIPUS AJUSTO UN COLOR DE LA CEL:LA*/

				/*LILA*/			if ($tipus=='A'){$color_cursDl14="#D698E7";}
				/*BLAUET*/		if ($tipus=='B'){$color_cursDl14="#98A9E7";}
				/*BLAU CLAR*/	if ($tipus=='C'){$color_cursDl14="#98D9E7";}
				/*VERD CLAR*/	if ($tipus=='D'){$color_cursDl14="#49F28D";}
				/*GROGUET*/		if ($tipus=='E'){$color_cursDl14="#D9E798";}
				/*SEPIA*/			if ($tipus=='F'){$color_cursDl14="#E7C598";}
				/*ROGET*/		if ($tipus=='G'){$color_cursDl14="#EAAD34";}
				/*GROC*/			if ($tipus=='H'){$color_cursDl14="#EAE734";}
				/*VERD*/			if ($tipus=='I'){$color_cursDl14="#43EA34";}
				/*BLAU*/			if ($tipus=='J'){$color_cursDl14="#34B0EA";}

				$minutet=date("i", $hora_sessio);
				if ($minutet==13){$Dl14=$profe;}
			}

$Dl15=Professor_Reserva($dia_1,$dia_11,$idaula,14);

			echo "<p align='center'><font face='Verdana' size='2' color='red'><b>Reserves aula ".$nom_aula."</b></font></p>
			<div align='center'>
	        		<table id='horari' width='1050px' class='tablesorter'  border='1' bgcolor='#CACAC0'>
		        	<thead>
			        <tr>
				        <th width='050px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dilluns $dia111</th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dimarts $dia211</font></th>
					<th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dimecres $dia311</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Dijous $dia411</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Divendres $dia511</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'   border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: 1a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl01'><font face='Verdana' size='1'>$Dl01</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
					<th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'   border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: 2a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl02'><font face='Verdana' size='1'>$Dl02</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'   border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: PATI 1</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl03'><font face='Verdana' size='1'>$Dl03</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr> 
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: 3a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl04'><font face='Verdana' size='1'>$Dl04</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: 4a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl05'><font face='Verdana' size='1'>$Dl05</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: PATI 2</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl06'><font face='Verdana' size='1'>$Dl06</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: 5a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl07'><font face='Verdana' size='1'>$Dl07</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Mati: 6a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl08'><font face='Verdana' size='1'>$Dl08</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Tarda: 1a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl09'><font face='Verdana' size='1'>$Dl09</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Tarda: 2a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl10'><font face='Verdana' size='1'>$Dl10</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Tarda: 3a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl11'><font face='Verdana' size='1'>$Dl11</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Tarda: PATI</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl12'><font face='Verdana' size='1'>$Dl12</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Tarda: 4a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl13'><font face='Verdana' size='1'>$Dl13</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Tarda: 5a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl14'><font face='Verdana' size='1'>$Dl14</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				<tr>
				        <th width='100px' align='left'       border='1' bgcolor='#CACACA'><font face='Verdana' size='1'>Tarda: 6a. hora</th>
				        <th width='200px' align='center' border='1' bgcolor='#color_cursDl15'><font face='Verdana' size='1'>$Dl15</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				        <th width='200px' align='center' border='1' bgcolor='#FFFFFF'><font face='Verdana' size='1'>----</font></th>
				</tr>
				</thead>
				</table>
			</div>";

			include "desconnectaBD.php";

			/*******************CONTROL D'ACCES FINAL********************************************************/
		}
		else{
			echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
		}
	}

	/******************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2015</font></p></body></html>