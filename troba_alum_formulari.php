<html><head><title>TROB.AL.</title> <script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head>
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1"><p align="left"><b>TROB.AL.</b></font></p></td>
<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>1. Tria alumne. 2. Prem el boto</b></p></td>
<td width="22%"><font face="Verdana" size="1"><p align="right"><b>TROBa Alumne</b></p></font></td>
</tr></table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

/*******************CONTROL DE ACCES INICI********************************************************/
require_once ('../config.php');
global $USER;
$userid=$USER->id;
if(!isloggedin()){
header('Location: http://iessitges.xtec.cat/login/index.php?id=284'); }
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

	if (($userid==7) OR (($userid <> 1) AND ($idprofe <> 0))){
	/***************************************************************************************************/

	$idalumne = $_POST["idalumne"];
	$comptador=1;

	echo "<table  style='text-align: left margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
		<tbody>
			<tr align='center'>
				<td width='100%'>
					<form method='POST' action='troba_alum_llistat.php'>
						<select  name='idalumne' class='select' >
							<option value=''>Tria un alumne</option>";

							/*MIRO A TOTS ELS USUARIS PER ORDRE ALFABETIC*/
							$sql3="SELECT * FROM mdl_user ORDER BY lastname";
							$result3=mysql_query($sql3, $conexion);
							while($row3=mysql_fetch_row($result3)){

								$idalumne=$row3[0];
								$alumne=$row3[11].", ".$row3[10];

								/*MIRO SI SON MEMBRES D'UNA COHORT D'ALUMNE*/
								$sql4="SELECT * FROM mdl_cohort a, mdl_cohort_members b WHERE ((a.idnumber LIKE '%ALUM%') AND (b.userid='$idalumne') AND (b.cohortid=a.id))";
								$result4=mysql_query($sql4, $conexion);
								while($row4=mysql_fetch_row($result4)){
									$grup=$row4[3];
									$comptador=$comptador+1;
									echo "<option value='$idalumne'>$alumne ($grup)</option>";
								}
							}

						echo "</select>";
						echo "<br>";
						echo "<br>";
						echo "<input value='Troba' type='submit'>";
						echo "<p align='center'><font face='Verdana' size='1' color='red'><br>$comptador alumnes</font></p>";
					echo "</form>
				</td>
			</tr>
		</tbody>
</table>";

include "desconnectaBD.php";

/*******************CONTROL DE ACCES FINAL********************************************************/
}
else{
	echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCES DENEGAT!</b></font></p>";
}
}
/******************************************************************************************************/

?>

<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2014</font></p></font></body></html>