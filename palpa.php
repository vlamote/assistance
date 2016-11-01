<html><head><title>PALPA</title></head><body bgcolor="#FFFFFF">
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="1"><a href="">PALPA</a></td>
<td width="65%"><p align="center"><font face="Verdana" size="2" color="red" style="BACKGROUND-COLOR: white">Programa d'Actualització de la llista Professors Actuals</font></P></td>
<td width="30%"><p align="right"><font face="Verdana" size="1"><b>PALPA</b></font></p></td></tr>
</table><hr>

<?php include "connectaBD.php";include "PassaVars.php";

echo "<p align='left'><font face='Verdana' size='2'><b>PROGRAMA QUE OMPLE ELS CAMPS -PROFE- DE TASQUES BD AMB TOTS ELS PROFES DE LA BD GENERAL</b><br>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA PROFES ID: 364 CAMP: Professor absent******************************/
/**************************************************************************************************************************/

$llista_profes="NINGU\n";
$valor=364;
$cohort=43;
$i=0;

/*USUARIS QUE PERTANYIN A LA COHORT DE PROFES*/

$sql2="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid=$cohort) AND (a.id=b.userid)) ORDER BY a.lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$i=$i+1;
	$llista_profes=$llista_profes.$row2[10]." ".$row2[11]."\n";
}

echo "<p align='left'><font face='Verdana' size='2'><b>01. Cercar llista professors actuals a la Base de Dades ...</b> Trobats ".$i." profes<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>02. Buidar llistats professors absents ...</b> FET.<br></font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID DE LA TAULA "MDL_DATA_FIELDS"  AMB 'NINGU' I LA llista PROFES*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_profes' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>03. Omplir llista professors absents amb llista professors actuals ...</b> FET</font></p>";


/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA PROFES CS (ID: 430 CAMP: Professor CS)******************************/
/**************************************************************************************************************************/
$llista_profes="";
$valor=430;
$cohort=43;
$i=0;

$sql2="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid=$cohort) AND (a.id=b.userid)) ORDER BY a.lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$i=$i+1;
	$llista_profes=$llista_profes.$row2[10]." ".$row2[11]."\n";
}

echo "<p align='left'><font face='Verdana' size='2'><b>04. Cercar llista professors actuals a la Base de Dades ...</b> Trobats ".$i." profes<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);
 
echo "<p align='left'><font face='Verdana' size='2'><b>05. Buidar llistats professors CS ...</b> FET</font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID DE LA TAULA "MDL_DATA_FIELDS"  AMB 'NINGU' I LA llista PROFES*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_profes' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>06. Omplir llista professors CS amb llista professors actuals...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA PROFES CS1 (ID: 441 CAMP: Profes Tribunal CS1)*******************************/
/**************************************************************************************************************************/
$llista_profes="";
$valor=441;
$cohort=43;
$i=0;

$sql2="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid='$cohort') AND (a.id=b.userid)) ORDER BY a.lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$i=$i+1;
	$llista_profes=$llista_profes.$row2[10]." ".$row2[11]."\n";
}

echo "<p align='left'><font face='Verdana' size='2'><b>07. Cercar llista professors actuals a la Base de Dades ...</b>Trobats ".$i." profes<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>08. Buidar llistats professors CS1 ...</b> FET.<br></font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID DE LA TAULA "MDL_DATA_FIELDS"  AMB 'NINGU' I LA llista PROFES*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_profes' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>09. Omplir llista professors CS1 amb llista professors actuals  ...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA PROFES CS2 (ID: 448 CAMP: Profes Tribunal CS2)*******************************/
/**************************************************************************************************************************/
$llista_profes="";
$valor=448;
$cohort=43;

$sql2="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid='$cohort') AND (a.id=b.userid)) ORDER BY a.lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$llista_profes=$llista_profes.$row2[10]." ".$row2[11]."\n";
}

echo "<p align='left'><font face='Verdana' size='2'><b>10. Cercar llista professors actuals a la Base de Dades ...</b>Trobats ".$i." profes<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>11. Buidar llistats professors CS2 ...</b> FET<br></font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID DE LA TAULA "MDL_DATA_FIELDS"  AMB 'NINGU' I LA llista PROFES*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_profes' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>12. Omplir llista professors CS2 amb llista professors actuals  ...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA PROFES CS3 (ID: 455 CAMP: Profes Tribunal CS3)*******************************/
/**************************************************************************************************************************/
$llista_profes="";
$valor=455;
$cohort=43;

$sql2="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid='$cohort') AND (a.id=b.userid)) ORDER BY a.lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$llista_profes=$llista_profes.$row2[10]." ".$row2[11]."\n";
}

echo "<p align='left'><font face='Verdana' size='2'><b>13. Cercar llista professors actuals a la Base de Dades ...</b>Trobats ".$i." profes<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>14. Buidar llistats professors CS3 ...</b> FET<br></font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID DE LA TAULA "MDL_DATA_FIELDS"  AMB 'NINGU' I LA llista PROFES*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_profes' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>15. Omplir llista professors CS3 amb llista professors actuals  ...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA PROFES CS4 (ID: 487 CAMP: Profes Tribunal CS4)*******************************/
/**************************************************************************************************************************/
$llista_profes="";
$valor=487;
$cohort=43;

$sql2="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid='$cohort') AND (a.id=b.userid)) ORDER BY a.lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$llista_profes=$llista_profes.$row2[10]." ".$row2[11]."\n";
}

echo "<p align='left'><font face='Verdana' size='2'><b>16. Cercar llista professors actuals a la Base de Dades ...</b>Trobats ".$i." profes<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>17. Buidar llistats professors CS4 ...</b> FET<br></font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID 649 DE LA TAULA "MDL_DATA_FIELDS"  AMB 'N/A' I LA llista serials*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_profes' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>18. Omplir llista professors CS4 amb llista professors actuals  ...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA CURSOS RESUM GRUPAL (ID: 610 CAMP: Materia)*******************************/
/**************************************************************************************************************************/
$llista_cursos="";
$valor=610;

$sql2="SELECT * FROM mdl_course WHERE (visible='1') ORDER BY fullname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$llista_cursos=$llista_cursos.$row2[3]."\n";
}

echo "<p align='left'><font face='Verdana' size='2'><b>19. Cercar llista cursos actuals a la Base de Dades ...</b>Trobats ".$i." cursos<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>20. Buidar llistats cursos Resum grupal ...</b> FET<br></font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID DE LA TAULA "MDL_DATA_FIELDS" AMB 'NINGU' I LA llista de cursos*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_cursos' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>21. Omplir llista cursos Resum grupal amb llista cursos actuals  ...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA SERIALS FORMULARI PRESTEC (ID: 194 CAMP: content )*******************************/
/**************************************************************************************************************************/
$llista_serials="N/A";
$valor=194;

$sql2="SELECT * FROM mdl_data_content WHERE (fieldid='$valor' AND content<>'' AND content<>'N/A') ORDER BY content ASC";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$llista_serials=$llista_serials."\n".$row2[3];
}

echo "<p align='left'><font face='Verdana' size='2'><b>22. Cercar llista serials actuals a la Base de Dades de portàtils ...</b>Trobats ".$i." serials<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DEL ID 'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='$llista_serials' WHERE id='649'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>23. Omplir llista serials Formulari Prestec Equipament Informàtic amb serials anteriorment trobats...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA USUARIS PRESTECS ARMARIETS (ID: 66 CAMP: content )*******************************/
/**************************************************************************************************************************/
$llista_usuaris="----";
$valor=700;
$i=0;

$sql2="SELECT * FROM mdl_user WHERE (deleted='0') and (lastname>='A') ORDER BY lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){

	$i=$i+1;

	/************************************************************************************************************/
	/*ATENCIO!!!! VAN HAVER PROBLEMES AMB USUARI D'ORSI QUE NO ACCEPTAVA I NO OMPLIA REGISTRE PARAM1*/
	/*ES VA RESOLDRE POSANT D_ORSI*/
	/************************************************************************************************************/
	$nom=str_replace("'","_",$row2[10]);
	$cognom=str_replace("'","_",$row2[11]);

	$llista_usuaris=$llista_usuaris."\n".$cognom.", ".$nom;
}

/*echo $llista_usuaris;*/

echo "<p align='left'><font face='Verdana' size='2'><b>24. Cercar llista usuaris actuals a la Base de Dades ...</b> Trobats ".$i." usuaris<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);
 
echo "<p align='left'><font face='Verdana' size='2'><b>25. Buidar llistats potencials usuaris armariets ...</b> FET</font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID DE LA TAULA "MDL_DATA_FIELDS"  AMB 'NINGU' I LA llista PROFES*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_usuaris' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>26. Omplir llista potencials usuaris armariets ...</b> FET</font></p>";

/**************************************************************************************************************************/
/*********************************ACTUALITZAR LLISTA USUARIS NETBOOKS (ID: 671 CAMP: content )*******************************/
/**************************************************************************************************************************/
$llista_profes="----"."\n"."INFO1"."\n"."INFO2"."\n"."CARRO (INFO3)"."\n"."CARRO (INFO4)"."\n"."Departament de ciències"."\n"."Departament de matemàtiques"."\n"."Taller de tecnologia"."\n"."----"."\n";
$valor=671;
$cohort=43;
$i=0;

/*OMPLO NOVA LLISTA PROFES*/

$sql2="SELECT * FROM mdl_user a, mdl_cohort_members b WHERE ((b.cohortid='$cohort') AND (a.id=b.userid)) ORDER BY a.lastname";
$result2=mysql_query($sql2, $conexion);
while($row2=mysql_fetch_row($result2)){
	$llista_profes=$llista_profes.$row2[10]." ".$row2[11]."\n";
	$i=$i+1;
}

echo "<p align='left'><font face='Verdana' size='2'><b>27. Cercar llista professors actuals a la Base de Dades ...</b>Trobats ".$i." profes<br></font></p>";

/*MODIFICAR CAMP 5 -PARAMETER1- DELS ID'S ANTERIORS DE LA TAULA "MDL_DATA_FIELDS" I BUIDAR-LO*/
$sql1 = "UPDATE mdl_data_fields SET param1='' WHERE id='$valor'";
$result1=mysql_query($sql1, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>28. Buidar llistats possibles professors Netbooks ...</b> FET<br></font></p>";

/*MODIFICAR CAMP 5 -PARAM1- DE L'ID 671 DE LA TAULA "MDL_DATA_FIELDS"  AMB 'N/A' I LA llista serials*/
$sql3 = "UPDATE mdl_data_fields SET param1='$llista_profes' WHERE id='$valor'";
$result3=mysql_query($sql3, $conexion);

echo "<p align='left'><font face='Verdana' size='2'><b>29. Omplir llista possibles professors Netbooks amb llista professors actuals  ...</b> FET</font></p>";

?></body></html>