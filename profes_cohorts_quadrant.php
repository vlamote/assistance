<html><head><title>PRO.CO.QUA.</title>
 
<LINK href="jquery/themes/blue/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script>
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script>

<script type="text/javascript">

$(document).ready(function() {
$("#cohorts").tablesorter({
sortList: [[0,0]]
});
});

</script>
</head><body bgcolor="#FFFFFF">
   
<table border="0" width="100%" id="table2"><tr>
<td width="22%"><font face="Verdana" size="1" color="black"><p align="left"><b><a href="/assistencia/profes_materies_formulari.php">LL.E.P.A.M.</a> | <a href="/assistencia/profes_cohorts_quadrant.php">Quadrant</a></p></td>
<td width="65%"><p align="center"><font face="Verdana" size="1" color="red" style="BACKGROUND-COLOR: white">Pica a la capçalera que vulguis per a ordenar segons aquell criteri</font></P></td>
<td width="30%"><p align="right"><font face="Verdana" size="1"><b>Professors - Cohorts (Quadrant)</b></font></p></td></tr>
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
$cohorts=array(0,0,0,0,0,0,0,0,0,0,0,0,);
$nom_cohorts=array("","","","","","","","","","","","");
$profes_BAT1=0;
$profes_BAT2=0;
$profes_CAGS=0;
$profes_CFGM1=0;
$profes_CFGM2=0;
$profes_CFGS1=0;
$profes_CFGS2=0;
$profes_ESO1=0;
$profes_ESO2=0;
$profes_ESO3=0;
$profes_ESO4=0;
$profes_CAGS=0;

/*********************************/
/* ENCAPSALAMENT DE LA TAULA */
/*********************************/

echo "
<div align='center'>
	<table id='cohorts' width='1175px' class='tablesorter'>
	<thead>
		<tr>
			<th width='330px' align='center'>Profe \ Nivell</th>";
				$i=0;
				$sql01 = "SELECT * FROM mdl_cohort WHERE (name LIKE '%PROFE%') AND (name<>'PROFE') AND (name<>'PROFE_GUARDIA') AND (name<>'PROFE_SUBS') AND (name<>'PROFE_PRAC') ORDER by name ASC";
				$result01=mysql_query($sql01, $conexion);
				while($row01=mysql_fetch_row($result01)){
					$cohorts[$i]=$row01[0];
					$nom_cohorts[$i]=$row01[3];
					$i=$i+1;
					$cohort_curta=substr($row01[3],5);
					echo "<th  width='65px' align='center'><font size='1'>$cohort_curta</font></th>";
				}
		echo "<th  width='65px' align='center'>Nivells</th>
		</tr>
	</thead>
</div>";

/************************/
/*DESO NOMS COHORTS*/
/************************/

/*******************************************/
/*LLISTO COHORT DE TOTS ELS PROFESSORS*/
/*******************************************/

$sql02 = "SELECT * FROM mdl_cohort WHERE name='PROFE' ORDER by name ASC";
$result02=mysql_query($sql02, $conexion);
while($row02=mysql_fetch_row($result02)){

	/**********************************/
	/*DE CADA COHORT AGAFO PROFE*/
	/*********************************/

	$sql03 = "SELECT * FROM mdl_cohort_members WHERE cohortid='$row02[0]' ORDER by cohortid ASC";
	$result03=mysql_query($sql03, $conexion);
	while($row03=mysql_fetch_row($result03)){

		/***********************/
		/*MIRO QUIN PROFE ES*/
		/**********************/

		$sql04 = "SELECT * FROM mdl_user WHERE id='$row03[2]'";
		$result04=mysql_query($sql04, $conexion);
		while($row04=mysql_fetch_row($result04)){

			$profe=$row04[11].", ".$row04[10];
			$idprofe=$row04[0];
		}

		/************************************/
		/*EL LLISTO A LA PRIMERA COLUMNA*/
		/************************************/

		echo"<tr><td align='left' bgcolor='$color' width='330px'><font face='Verdana' size='1'>$profe</font></td>";

		$nivells=0;

		/************/
		/*COHORT 0*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[0]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_BAT1=$profes_BAT1+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[0];
		$titolet=$nom_cohorts[0];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 1*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[1]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_BAT2=$profes_BAT2+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[1];
		$titolet=$nom_cohorts[1];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 2*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[2]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_CAGS=$profes_CAGS+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[2];
		$titolet=$nom_cohorts[2];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 3*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[3]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_CFGM1=$profes_CFGM1+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[3];
		$titolet=$nom_cohorts[3];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 4*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[4]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_CFGM2=$profes_CFGM2+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[4];
		$titolet=$nom_cohorts[4];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 5*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[5]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_CFGS1=$profes_CFGS1+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[5];
		$titolet=$nom_cohorts[5];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 6*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[6]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_CFGS2=$profes_CFGS2+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[6];
		$titolet=$nom_cohorts[6];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 7*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[7]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_ESO1=$profes_ESO1+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[7];
		$titolet=$nom_cohorts[7];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 8*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[8]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_ESO2=$profes_ESO2+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[8];
		$titolet=$nom_cohorts[8];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 9*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[9]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_ESO3=$profes_ESO3+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[9];
		$titolet=$nom_cohorts[9];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 10*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[10]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_ESO4=$profes_ESO4+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[10];
		$titolet=$nom_cohorts[10];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";

		/************/
		/*COHORT 11*/
		/***********/
		$cohort_curta="---";

		/********************************************************/
		/*MIRO SI EL PROFESSOR ES MEMBRE D'AQUELLA COHORT*/
		/********************************************************/
			
		$sql05 = "SELECT * FROM mdl_cohort_members WHERE userid='$idprofe' AND cohortid= '$cohorts[11]'";
		$result05=mysql_query($sql05, $conexion);
		while($row05=mysql_fetch_row($result05)){

			$cohort_curta="X";
			$nivells=$nivells+1;
			$profes_PFI=$profes_PFI+1;
		}

		/***************************************/
		/*MOSTRO NOM COHORT O X SI NO N'ES*/
		/***************************************/
		$enllacet="/cohort/assign.php?id=".$cohorts[11];
		$titolet=$nom_cohorts[11];
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'><a href='$enllacet' title='$titolet'>$cohort_curta</a></font></td>";
		echo"<td align='center' bgcolor='$color'  width='65px'><font face='Verdana' size='1'>$nivells</font></td>";
		echo "</tr>";

	}
}
echo"<tr><td align='center' bgcolor='$color' width='330px'><font face='Verdana' size='1'>ZTotalsZ</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_BAT1</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_BAT2</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_CAGS</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_CFGM1</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_CFGM2</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_CFGS1</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_CFGS2</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_ESO1</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_ESO2</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_ESO3</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_ESO4</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>$profes_PFI</font></td>";
echo"<td align='center' bgcolor='$color' width='65px'><font face='Verdana' size='1'>Prof\Niv</font></td>";
echo "</table><hr><p align='center'><font face='Verdana'  size='1'>(c) V.L.G.A. 2015</font></p>";
?>
</body></html>