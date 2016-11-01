<?php

define('FPDF_FONTPATH','fpdf/font/');

require('fpdf/fpdf.php');

class PDF extends FPDF
{
	//Funció que rebrà tots el registres procedents de la consulta que faci l'usuari
	function muntataula($header){

		//Recollim les dades enviades desde la selecció de l'usuari
		$registrespdf=unserialize(base64_decode($_POST['esdeveniments_profes_llistat_pdf']));

		//Com rebem les dades desordenades procedim a ordenar-les....
	
		//Recorrem tots els registres rebuts, i crearem un nou array amb les dades de la columna per la que volem ordenar. En aquest cas ordenaré per la columna Alumne ($fila[4])...4 es l'index de la columna corresponent a alumne
		foreach ($registrespdf as $clau => $fila){

			 //Selecciono la columna dels Alumnes per ordenar per nom i passem tots els valors a un nou array $columnaordenada...
			$columnaordenada[$clau] = $fila[1];
		}

		//Utilitzem la funció que compara 2 arrays i els ordena. Ja tenim ordenats els nostres registres per la columna alumnes...
		array_multisort($columnaordenada, SORT_ASC, $registrespdf);

		//Definim amplada de les columnes de la taula
		$w=array(31,13,130,25);

		for($i=0;$i<count($header);$i++){

			$this->Cell($w[$i],5,$header[$i],1);
		}
		
		$this->Ln();
	
		//Muntem les dades
		foreach($registrespdf as $row){
	
			$j=0;
	
			foreach ($row as $col){
		
				$this->Cell($w[$j],5,$col,1);
				$j++;
		
			}
			$this->Ln();
		}
	} 	

	//Funció que mostra la capçalera dels pdf
	function Header()
	{
		$this->Image('logo.jpg',10,8,50);
		$this->SetFont('Courier','',15);
		$this->Cell(80);
		$this->Cell(100,10,utf8_decode("ESDEVENIMENTS PROPERS"),1,0,'C');
		$this->Ln(20);
	}

	//Funció que mostra el peu dels pdf
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Courier','',8);
		$this->Cell(0,8,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

//Orientació vertical
$pdf = new PDF('P','mm','A4'); 

//Orientació horitzontal
//$pdf = new PDF('L','mm','A4');

$pdf->AliasNbPages();
$pdf->AddPage();

//Construïm els títols per cadasquna de les nostres columnes que formaran la taula pdf
$header=array('Data','Durada','Esdeveniment','Convocats');
$pdf->SetFont('Courier','',8);
$pdf->muntataula($header);

//Sortida
$pdf->Output();

?>