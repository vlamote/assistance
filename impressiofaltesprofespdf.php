<?php define('FPDF_FONTPATH','fpdf/font/');require('fpdf/fpdf.php');

//Classe
class PDF extends FPDF
{

	//Funció que rebrà tots el registres procedents de la consulta que faci l'usuari
	function muntataula($header){

	//Recollim les dades enviades desde la selecció de l'usuari
	$registrespdf=unserialize($_POST['llistapdf']);

	//Com rebem les dades desordenades procedim a ordenar-les....
	//Recorrem tots els registres rebuts, i crearem un nou array amb les dades de la columna per la que volem ordenar. En aquest cas ordenaré per la columna Alumne ($fila[4])...4 es l'index de la columna corresponent a alumne
	foreach ($registrespdf as $clau => $fila){

		 //Selecciono la columna dels Alumnes per or $coludenar per nom i passem tots els valors a un nou array $columnaordenada...
		$columnaordenada[$clau] = $fila[4];
	}

	//Utilitzem la funció que compara 2 arrays i els ordena. Ja tenim ordenats els nostres registres per la columna alumnes...
	array_multisort($columnaordenada, SORT_ASC, $registrespdf);

	//Definim amplada de les columnes de la taula
	$w=array(100,22,25,22,22,22,22,22);

	for($i=0;$i<count($header);$i++){

		$this->Cell($w[$i],7,$header[$i],1);}
		$this->Ln();

		//Muntem les dades
		foreach($registrespdf as $row){

			$j=0;

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
		$this->Image('logo.jpg',10,8,50);
		$this->SetFont('Courier','',15);
		$this->Cell(80);
		$this->Cell(180,10,utf8_decode("ESTADISTIQUES DE FALTES DE PROFESSORS"),1,0,'C');
		$this->Ln(20);
	}

	//Funció que mostra el peu dels pdf
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Courier','',8);
		$this->Cell(0,10,'Page   '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

//Orientació horitzontal
$pdf = new PDF('L','mm','A4'); 
$pdf->AliasNbPages();
$pdf->AddPage();

//Construïm els títols per cadasquna de les nostres columnes que formaran la taula pdf
$header=array('Professor','Pendents','Malalties','Baixes','Reunions','Permisos','Sortides','Totals');
$pdf->SetFont('Courier','',12);
$pdf->muntataula($header);

//Sortida
$pdf->Output();

?>