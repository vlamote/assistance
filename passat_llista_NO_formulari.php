<html><head><script language="javascript" type="text/javascript" src="datetimepicker.js"></script></head><title>NO.S.PA.LLI.</title></head>
	<body>
		<table border="0" width="100%" id="table2">
			<tr>
				<td width="22%"><font face="Verdana" size="1" color="black"><p align="left"><b>NO.S.PA.LLI.</b></p></td>
				<td width="56%"><font face="Verdana" size="1" color="red"><p align="center"><b>Si no es posa data mirarà un mes en darrera</b></p></td>
				<td width="65%"><p align="right"><font face="Verdana" size="1" color="black">NO S'ha PAssat LLIsta</font></P></td>
			</tr>
		</table>
		<hr>

		<?php include "connectaBD.php";include "PassaVars.php";

		/*******************CONTROL DE ACCES INICI********************************************************/
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
			/***************************************************************************************************/

			//EL PAS DE VARIABLES NO FUNCIONAVA A INTERNET (SI EN INTRANET) DEU ESTAR "REGISTERGLOBALS" A "OFF" AL SERVIDOR, PER QUESTIONS DE SEGURETAT
			$data1 = $_POST["data1"];
			$data2 = $_POST["data2"];

			//TAULA AMB FORMULARI
			echo "<table  style='text-align: center margin-left: auto; margin-right: auto; width:100%; height: 44px;' border='0'>
				<tbody>
					<tr align='center'>
						<td width='100%'>
							<form method='get' action='passat_llista_NO_llistat.php?data1=$data1&data2=$data2'>
								<font face='Arial' size='2'>";
echo <<< HTML
<input name="data1" id="data1" type="text" size="7"><a href="javascript:NewCal('data1','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>
<input name="data2" id="data2" type="text" size="7"><a href="javascript:NewCal('data2','ddmmmyyyy')"><img src="imatges/cal.gif" width="16" height="16" border="0" title="Tria una data"></a>
HTML;
								echo "
				        			</font>
				        			<input value='Mostra incidències' type='submit'>
							</form>
						</td>
					</tr>
				</tbody>
			</table>";

			include "desconnectaBD.php";

			/*******************CONTROL DE ACCES FINAL********************************************************/
			}
			else{
				echo"<p align='center'><font face='Verdana' size='2' color='red'><b>ACCÉS DENEGAT!</b></font></p>";
			}
		}
		/******************************************************************************************************/
		?>
		<hr>
		<p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2015</font></p>
	</body>
</html>