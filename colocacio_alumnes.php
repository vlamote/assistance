<html><head><title>COL.AL.</title><head></head>
<table border="0" width="100%" id="table2"><tr>
<td width="10%"><p align="left"><font face="Verdana" size="2"><a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_propis_llistat.php" title="Llista les col.locacions d'aules meves">Meus</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_llistat.php" title="Llista totes les col.locacions d'aules">Tots</a> | <a href="http://iessitges.xtec.cat/assistencia/colocacio_alumnes_crea_formulari.php" title="Crea la teva propia col.locacio d'alumnes">Crea</a></font></p></td>
<td width="65%"><p align="center"><font face="Verdana" size="2" color="red" style="BACKGROUND-COLOR: white">Pica als botons de cada cel.la per a modificar-la</font></p></td>
<td width="30%"><p align="right"><font face="Verdana" size="2"><b>Col:locacio dels ALumnes (COL.AL.)</b></font></p></td></tr>
</table><hr>

<?php include "connectaBD.php";include "PassaVars.php";include "Funcions_Usuaris.php";include "Funcions_Aules.php";

	/************************/
	/*ESBRINO COLOR  CELA*/
	/***********************/
	function ColorCela($id_cela){
		if($id_cela==-1){
			$hexacolor="#FFFFFF";
		}
		else{
			$hexacolor="#CCFFCC";
		}
		return $hexacolor;
	}

	/**********************/
	/*ESBRINO MIDA CELA*/
	/*********************/
	function AmpladaCela($id_cela){
		if($id_cela==-1){
			$pxamplada="51px";
		}
		else{
			$pxamplada="100px";
		}
		return $pxamplada;
	}

	/************************/                          
	/*ESBRINO COLOR AULA */
	/************************/
	Function ColorAula($id_aula){
		include "connectaBD.php";
		$sql44 = "SELECT * FROM mdl_block_mrbs_room WHERE id=$id_aula";
		$result44=mysql_query($sql44, $conexion);
		while($row44=mysql_fetch_row($result44)){
			$area_aula=$row44[1];
		}
		$sql444= "SELECT * FROM mdl_block_mrbs_area WHERE id=$area_aula";
		$result444=mysql_query($sql444, $conexion);
		while($row444=mysql_fetch_row($result444)){
			$nom_area=$row444[1];
		}
		$color_aula="#FFFFFF";
		if($nom_area=="VERD"){$color_aula="#5bb25f";}
		if($nom_area=="ROIG"){$color_aula="#c64371";}
		if($nom_area=="BLAU"){$color_aula="#5158c1";}
		if($nom_area=="INFO"){$color_aula="#5bb25f";}
		if($nom_area=="LABS"){$color_aula="#5bb25f";}
		return $color_aula;
	}
	
	/************************/   
	/*DIBUIXO ELS PUPITRES*/
	/***********************/   
	$sql1 = "SELECT * FROM mdl_zzz_aules WHERE (id_profe= '$id_profe' AND id_aula= '$id_aula' AND id_grup= '$id_grup')";
	$result1=mysql_query($sql1, $conexion);
	while($row1=mysql_fetch_row($result1)){
		$registre=$row1[0];
		$filera=6;
		echo"<table border='1' width='900px' id='colocacio' align='center'>";
			for($filera==6;$filera>=1;$filera--){
				echo"<tr>";
					$columna=1;
					for($columna==1;$columna<=9;$columna++){
						$indise=(9*($filera-1)+($columna+3));
						$LED="imatges/LED_incidencia_".$acronim.".gif";
						$color=ColorCela($row1[$indise]);
						$amplada=AmpladaCela($row1[$indise]);
						$nomalum=NomUsuari($row1[$indise]);
						$FotoUsuari=FotoUsuari($row1[$indise]);
						$id_alumne=$row1[$indise];
						echo "<td align='center' bgcolor='$color' width='$amplada' height='100px'>";
							if(($row1[$indise]<>-1) AND ($row1[$indise]<>0)){echo "<img src='$FotoUsuari' title='$nomalum $row1[indise]'>";}
							echo "<br>
							<a href='http://iessitges.xtec.cat/assistencia/colocacio_alumnes_posa.php?registre=$registre&cela=$indise&id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula' title='Posa alumne'><img src='http://iessitges.xtec.cat/assistencia/imatges/LED_incidencia_U.gif' alt='Posa alumne' height='15' width='15'></a>
							<a href='http://iessitges.xtec.cat/assistencia/colocacio_alumnes_treu.php?registre=$registre&cela=$indise&id_alumne=$row1[$indise]&id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula' title='Treu alumne'><img src='http://iessitges.xtec.cat/assistencia/imatges/LED_incidencia_S.gif' alt='Treu alumne' height='15' width='15'></a>
							<a href='http://iessitges.xtec.cat/assistencia/colocacio_alumnes_pass.php?registre=$registre&cela=$indise&id_alumne=$row1[$indise]&id_profe=$id_profe&id_grup=$id_grup&id_aula=$id_aula' title='Treu taula'><img src='http://iessitges.xtec.cat/assistencia/imatges/LED_incidencia_M.gif' alt='Treu taula' height='15' width='15'></a>
						</td>";
					}
				}
			echo"</tr>";
			echo"<tr>";
				$color=ColorAula($id_aula);
				$nom_profe=NomUsuari($id_profe);
				$foto_profe=FotoUsuari($id_profe);
				$nom_grup=NomGrup($id_grup);
				$nom_aula=NomAula($id_aula);		
				echo"
				<td colspan='9' align='center' bgcolor='#5bb25f' width='$amplada' height='100px'>
					<font face='Verdana' size='3' color='$FFFFFF'>Col.locacio alumnes grup <b>".$nom_grup." </b> a l'aula <b>".$nom_aula."</b><br><img src='$foto_profe' title='$nom_profe'><br>Professor: <b>".$nom_profe."</b></font>
				</td>";
			echo"</tr>";
		echo"</table>";
	}
?>
<hr><p align="center"><font face="Verdana" size="1">(c) V.L.G.A. 2016</font></p></body></html>
