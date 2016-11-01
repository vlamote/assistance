<html><head><title>LL.E.P.A.M.</title>
 
<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>

<script type="text/javascript">

$(document).ready(function() {
$("#Incidencies").tablesorter({
sortList: [[0,0],[1,0],[2,0]]
});
});

</script>
</head><body bgcolor="#FFFFFF">
   
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="/assistencia/profes_materies_formulari.php">Nova consulta</a></td>
<td width="65%"><p align="center"><font face="Verdana" size="1" color="red" style="BACKGROUND-COLOR: white">1. Pica a la capçalera que vulguis per a ordenar.<br>2. Pica a la matèria per actualitzar.<br>3. Si no surt la matèria és que, o no:<br>-Té profes entrats<br>-Té curs i etapa posat a la descripció curta del nom Moodle<br>-Està visible el curs</font></P></td>
<td width="30%"><p align="right"><font face="Verdana" size="1"><b>LListat d'Equivalencies de Professors Amb Materies(LL.E.P.A.M.)</b></font></p></td></tr>
</table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/***************************/
/* DEFINICIO DE VARIABLES */
/**************************/
$alumne="---";
$profe="---";
$sessio="---";
$identificador=1;
$assistencia="---";
$curs="---";
$nivell = $_GET["nivell"];
$idalumne = $_POST["idalumne"];
?>
 
<!--  /* ENCAPSALAMENT DE LA TAULA */ -->
   
<div align='center'>
        <table id="Incidencies" width="600px" class="tablesorter">
        <thead>
            <tr>
            <th width='100px' align='center'>Curs</th>
            <th width='300px' align='center'>Matèria</th>
            <th width='200px' align='center'>Professor</th>
            </tr>
        </thead>
</div>

<?php

	/***********************************************************************************************************/
	/*1. BUSCO A ROLE_ASSIGNMENT TOTS ELS REGISTRES AMB ROLEID=3 -PROFESSOR- I ORDENAT PER CONTEXTID*/
	/***********************************************************************************************************/
	$sql1 = "SELECT * FROM mdl_role_assignments WHERE roleid='3' and contextid<>'19292' and contextid<>'2' and contextid<>'3017' and contextid<>'3186' and contextid<>'3316' and contextid<>'3640' and contextid<>'3644' and contextid<>'3664' and contextid<>'7440' and contextid<>'7536' and contextid<>'10593' and contextid<>'10782' and contextid<>'19316' and contextid<>'19308' and contextid<>'19300' and contextid<>'19282' and contextid<>'19283' and contextid<>'19275' and contextid<>'19267' and contextid<>'19077' ORDER by contextid ASC";

	$result1=mysql_query($sql1, $conexion);
	while($row1=mysql_fetch_row($result1)){

		$context=$row1[2];

		/***********************************************/   
		/* 2. ESBRINO INSTANCIA A PARTIR DEL CONTEXT*/
		/***********************************************/   
		$sql2 = "SELECT * FROM mdl_context WHERE id=$context";
		$result2=mysql_query($sql2, $conexion);
		while($row2=mysql_fetch_row($result2)){

			$instancia=$row2[2];

			/***************************/
			/*ESBRINO ID ENROLAMENT*/
			/***************************/
			$sql222 = "SELECT * FROM mdl_enrol WHERE (courseid='$instancia') AND (enrol='manual')";
			$result222=mysql_query($sql222, $conexion);
			while($row222=mysql_fetch_row($result222)){
				
				$enrolament=$row222[0];
			}
			
			$enllascurs="http://iessitges.xtec.cat/enrol/manual/manage.php?enrolid=$enrolament";

			/*********************/ 
			/*3. ESBRINO EL CURS*/
			/*********************/ 
			$sql3 = "SELECT * FROM mdl_course WHERE (id=$instancia) AND (visible='1')";
			$result3=mysql_query($sql3, $conexion);
			while($row3=mysql_fetch_row($result3)){

				$nomcurtcurs=$row3[4];
				$nomcurs=$row3[3];
				$categoria=$row3[1];
				$enllascategoria="http://iessitges.xtec.cat/course/index.php?categoryid=$categoria";

				/**********************************/   
				/*4. ESBRINO CATEGORIA DEL CURS*/
				/*********************************/ 
				$sql4 = "SELECT * FROM mdl_course_categories WHERE (id=$categoria)";
				$result4=mysql_query($sql4, $conexion);
				while($row4=mysql_fetch_row($result4)){

					$nomcategoria=$row4[1];
	
					/**************************/   
					/* 5. ESBRINO NOM PROFE*/
					/**************************/   
					$sql5 = "SELECT * FROM mdl_user WHERE id=$row1[3]";
					$result5=mysql_query($sql5, $conexion);
					while($row5=mysql_fetch_row($result5)){

						$profe=$row5[11].", ".$row5[10];
						$idalumne=$row1[3];
					}

					if ((substr_count($nomcurtcurs,$nivell)<>0) or ($nivell=="Tots")) {
						echo"
						<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'><a href=$enllascategoria title='Salta al curs' target='blank'>$nomcategoria</a>
						<td align='left' bgcolor='$color' width='250px'><font face='Verdana' size='1'><a href=$enllascurs title='Inscriu profes' target='blank'>$nomcurs ($instancia)</a>
						<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'><a href='profes_materies_horari.php?idalumne=$row1[3]' target='blank' title='Salta a horari $profe'>$profe</a>
						</font></td></tr>";
	
						$identificador=$identificador+1;
					}	
				}
			}
		}
	}
echo"<p align='center'><font face='Verdana'  size='1'><b>Total de registres:</b> $identificador</font></p>";
?>

</body></html>