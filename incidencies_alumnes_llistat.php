<html>
	<head><title>G.R.I.AL.</title>
		<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="jquery/jquery-latest.js"></script>
		<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#Incidencies").tablesorter({
				sortList: [[4,0],[0,0],[5,1]]
			});
		});
		</script>
	</head>

	<body bgcolor="#FFFFFF">
		<table border="0" width="100%" id="table2"><tr>
			<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="/assistencia/incidencies_alumnes_formulari.php">Nova consulta</a></td>
			<td width="65%"><p align="center"><font face="Verdana" size="1" color="black" style="BACKGROUND-COLOR: white">Contacta amb: <a href="http://iessitges.xtec.cat/user/index.php?contextid=3017&roleid=0&id=24&perpage=20&accesssince=0&search=&group=6" title="Coordinadors" target="blank">Coordinacio</a> | <a href="http://iessitges.xtec.cat/user/index.php?contextid=3017&roleid=0&id=24&perpage=20&accesssince=0&search=&group=18" title="Direcció" target="blank">Direccio</a><font></P></td>
			<td width="30%"><p align="right"><font face="Verdana" size="1"><b>Gestio Remota Incidencies ALumnes (G.R.I.AL.)</b></font></p></td></tr>
		</table><hr>

		<?php include "connectaBD.php";include "PassaVars.php";include "sessionlib.php";include "Funcions_Matrius.php";
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

			if (($userid==7) OR (($userid <> 1) AND ($userid <> 7) AND ($idprofe <> 0))){
				$alumne="---";
				$profe="---";
				$sessio="---";
				$identificador=0;
				$enllas="mod/attforblock/view.php";
				$LED="imatges/LED_incidencies_OFF.gif";
				$sessio="---";
				$assistencia="---";
				$curs="---";
				$nomcurs="---";
				$nomgrup="---";
				$cursoficial="N/A";
				$grupoficial="N/A";
				$tipus = $_GET["tipus"];
				$triacurs[] = $_GET["triacurs[]"];
				$data1= $_GET["data1"];
				$data2 = $_GET["data2"];
				$id_cohort = $_GET["id_cohort"];
				$dataentrada1= strtotime($data1);
				$dataentrada2= strtotime($data2);
				$abans=time();

				if ($data1=="" AND $data2==""){
					$dataentrada1=time()-2592000;
					$data1=date("d-m-y",$dataentrada1);
					$dataentrada2=time();
					$data2=date("d-m-y",$dataentrada2);
				}

				echo "<p align='center'><font face='Verdana' size='1'><b> Periode: </b>".$data1." al ".$data2."<br><br><font color='red'>
Posa el ratoli sobre el <img src='$LED'> per veure mes info
 i/o clica per a anar al detall.<br>
L'ordenacio per defecte es per alumne, 
per data i per incidencia.<br>
Pica a la capsalera (o capsaleres -amb la tecla Shift-) que vulguis per a ordenar segons aquell criteri.</font></p>";

				?>

				<div align='center'>
			        <table id="Incidencies" width="500px" class="tablesorter">
					<thead>
						<tr>
					            <th width='100px' align='center'>Data</th>
					            <th width='100px' align='center'>Materia</th>
					            <th width='100px' align='center'>Alumne</th>
					            <th width='100px' align='center'>Incidencia</th>
					            <th width='100px' align='center'>Observacions</th>
				            </tr>
					</thead>
				</div>

				<?php

				echo"<p align='center'><font face='Verdana' size='1'><b>Incidencies: </b>";

				if($tipus=="T"){echo "Totes les incidencies";}
				if ($tipus=="F"){$nom_acronim="Falta no justificada";echo"Faltes d'assistencia";}
				if ($tipus=="R"){$nom_acronim="Retard";echo"Retards";}
				if ($tipus=="E"){$nom_acronim="Expulsio";echo"Expulsions";}
				if ($tipus=="S"){$nom_acronim="Sancio";echo"Sancions";}
				if ($tipus=="J"){$nom_acronim="Falta justificada";echo"Justificacions";}
				if ($tipus=="P"){$nom_acronim="Observacions";echo"Observacions";}		
				if($tipus=="U"){$nom_acronim="Reunio";}
				if($tipus=="I"){$nom_acronim="Permis";}
				if($tipus=="M"){$nom_acronim="Marcat per error";}		
				if($tipus=="D"){$nom_acronim="Sortida";}
				if($tipus=="B"){$nom_acronim="Baixa";}

				echo"<p align='center'><font face='Verdana' size='1'><b>Cursos: </b>";

foreach ($triacurs as $tria_curs){

				echo"<p align='center'><font face='Verdana' size='1'>".$nom_cohort;

				$sql1="SELECT * FROM mdl_cohort WHERE id='$tria_curs'";
				$result1=mysql_query($sql1,$conexion);
				WHILE($row1=mysql_fetch_row($result1)){
					$nom_cohort=substr($row1[3],4);
				}
				
				$sql1="SELECT * FROM mdl_cohort_members WHERE cohortid='$tria_curs'";
				$result1=mysql_query($sql1,$conexion);
				WHILE($row1=mysql_fetch_row($result1)){

					$alumne=$row1[2];

					$sql2="SELECT * FROM mdl_attendance_log WHERE  timetaken>='$dataentrada1' AND timetaken<='$dataentrada2' AND studentid='$alumne'";
					$result2=mysql_query($sql2,$conexion);
					WHILE($row2=mysql_fetch_row($result2)){

						$dataincid=date("y-m-d H:i",$row2[5]);
						$idsessio=$row2[1];
						$idprofe=$row2[6];
						$observacions=$row2[7];
						$idestat=$row2[3];

						$sql22="SELECT * FROM mdl_attendance_sessions WHERE id='$idsessio'";
						$result22=mysql_query($sql22,$conexion);
						WHILE($row22=mysql_fetch_row($result22)){
							$idgrup=$row22[2];
							$assistencia=$row22[1];
						}

						$sql212="SELECT * FROM mdl_groups WHERE id='$idgrup'";
						$result212=mysql_query($sql212,$conexion);
						WHILE($row212=mysql_fetch_row($result212)){
							$idcurs=$row212[1];
						}

						$sql213="SELECT * FROM mdl_course WHERE id='$idcurs'";
						$result213=mysql_query($sql213,$conexion);
						WHILE($row213=mysql_fetch_row($result213)){
							$nomcurs=$row213[4];
						}

						$sql222="SELECT * FROM mdl_user WHERE id='$alumne'";
						$result222=mysql_query($sql222,$conexion);
						WHILE($row222=mysql_fetch_row($result222)){
							$nom_alumne=$row222[11].", ".$row222[10];
						}

						$sql232="SELECT * FROM mdl_user WHERE id='$idprofe'";
						$result232=mysql_query($sql232,$conexion);
						WHILE($row232=mysql_fetch_row($result232)){
							$nomprofe=$row232[11].", ".$row232[10];
						}

						$sql0="SELECT * FROM mdl_attendance_statuses WHERE id='$idestat'";
						$result0=mysql_query($sql0,$conexion);
						WHILE($row0=mysql_fetch_row($result0)){
							$acronimestat=$row0[2];
							$LED="imatges/LED_incidencia_".$acronimestat.".gif";
							$popup="Incidencia: ".$acronimestat.". Notificada per: ".$nomprofe;
						}

						$sql5 = "SELECT * FROM mdl_attforblock WHERE id=$assistencia";
						$result5=mysql_query($sql5, $conexion);
						while($row5=mysql_fetch_row($result5)){
							$curs=$row5[1];
						}

						$sql6 = "SELECT * FROM mdl_course_modules WHERE (course=$curs AND instance=$assistencia)";
						$result6=mysql_query($sql6, $conexion);
						while($row6=mysql_fetch_row($result6)){
							$enllas='http://iessitges.xtec.cat/mod/attforblock/view.php?id='.$row6[0].'&studentid='.$row1[2].'&view='."5";
						}

						if(($tipus == $acronimestat) OR ($tipus == 'T')){

							if(($observacions=='') AND ($acronimestat=='P')){
							}
							else{
								echo"<tr>                                
									<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$dataincid</font></td>
									<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$nomcurs</font></td>
									<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$nom_alumne</font></td>
									<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1' color='white'>$acronimestat <a href='$enllas' title='$popup' target='blank'><img src='$LED'></a></font></td>
									<td align='center' bgcolor='$color' width='100px'><font face='Verdana' size='1'>$observacions</font></td>
								</tr>";

								$incidencies[$identificador]=$nom_alumne;
								$identificador=$identificador+1;
							}
						}
					}}
				}
			}
			else{
				echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
			}
		}

/*****************/
/*ESTADISTIQUES*/
/*****************/

$color="#0000ff";
echo "<table id='estadistiquesincidencies' width='400px' class='tablesorter'>";
	echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#000000'><b>ESTADISTIQUES</b></td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'></td>";
	echo "</tr>";
	$color="#666699";
	echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Usuari</td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1' color='#0000ff'>Incidencies</td>";
	echo "</tr>";
	$incidencies=repeatedElements($incidencies, TRUE);
	foreach ($incidencies as $key => $row) {
		$color="#FFFFFF";
		$vumetre="";
		for ($i=0; $i<$row['vegades']; $i++){
			$vumetre=$vumetre."#";
		}

	echo "<tr>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$row['valor']."</td>";
		echo "<td align='left' bgcolor='$color' width='200px'><font face='Verdana' size='1'>".$vumetre.$row['vegades']."</td>";
	echo "</tr>";
}
echo "</table>";

		?>
		</table><hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. & J.J.M.R. 2016</font></p>
	</body>
</html>