<?php

//error_reporting(E_ALL|E_STRICT);
//ob_end_clean();
//header('Content-Type: text/html; charset=iso-8859-1');

define('FPDF_FONTPATH','fpdf/font/');

require('fpdf/fpdf.php');

class PDF extends FPDF
{

	//Funció que rebrà tots el registres procedents de la consulta que faci l'usuari
	function muntataula($header){

		//Recollim les dades enviades desde la selecció de l'usuari
		$registrespdf=unserialize($_POST['llistapdf']);
		
		//Com rebem les dades desordenades procedim a ordenar-les....

		//Recorrem tots els registres rebuts, i crearem un nou array amb les dades de la columna per la que volem ordenar. En aquest cas ordenaré per la columna Alumne ($fila[4])...4 es l'index de la columna corresponent a alumne
		foreach ($registrespdf as $clau => $fila){

			$columnaordenada[$clau] = $fila[4]; //Selecciono la columna dels Alumnes per ordenar per nom i passem tots els valors a un nou array $columna ordenada...
			
			
		}

		//Utilitzem la funció que compara 2 arrays i els ordena. Ja tenim ordenats els nostres registres per la columna alumnes...
		array_multisort($columnaordenada, SORT_ASC, $registrespdf);

		//Definim amplada de les columnes de la taula
		$w=array(100,50,50,50);

		for($i=0;$i<count($header);$i++){
			$this->Cell($w[$i],7,$header[$i],1);
		}
		
		$this->Ln();

		//Muntem les dades
		foreach($registrespdf as $row){
			$j=0;
			$alumne=$row[0];
			
			foreach ($row as $col){
				$this->Cell($w[$j],7,$col,1);
				$j++;
				
			}
			
			$this->Ln();
			
		}		
}

	//Funció que mostra la capçalera dels pdf
	function Header()
	{
		
		global $alumne;
		$this->Image('logo.jpg',10,8,50);
		$this->SetFont('Courier','',15);
		$this->Cell(80);
		$this->Cell(180,10,'NOTES ALUMNES',1,0,'C');
		$this->Ln(20);
	}

	//Funció que mostra el peu dels pdf
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Courier','',8);
		$this->Cell(0,10,$alumne.'Pag   '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

//Orientació horitzontal
$pdf = new PDF('L','mm','A4'); 

//$pdf = new PDF();

$pdf->AliasNbPages();

$pdf->AddPage();

 

//Construïm els títols per cadasquna de les nostres columnes que formaran la taula pdf
$header=array('Alumne','Curs','Concepte','Nota / Nota max.');
$pdf->SetFont('Courier','',12);
$pdf->muntataula($header);
$pdf->Output();

?>