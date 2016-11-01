<?php include "connectaBD.php"; include "PassaVars.php";

/*PER A NO TENIR PROBLEMES AMB CARACTERS ESTRANYS*/
header("Content-Type: text/html;charset=utf-8");
mysql_query("SET NAMES 'utf8'");

/*INICI FUNCIO DE CONTAR REPETITS*/

function repeatedElements($array, $returnWithNonRepeatedItems = true)
{
	$repeated = array();

	foreach( (array)$array as $value )
	{
		$inArray = false;

		foreach( $repeated as $i => $rItem )
		{
			if( $rItem['valor'] === $value )
			{
				$inArray = true;
				++$repeated[$i]['vegades'];
			}
		}

		if( false === $inArray )
		{
			$i = count($repeated);
			$repeated[$i] = array();
			$repeated[$i]['valor'] = $value;
			$repeated[$i]['vegades'] = 1;
		}
	}

	if( ! $returnWithNonRepeatedItems )
	{
		foreach( $repeated as $i => $rItem )
		{
			if($rItem['vegades'] === 1)
			{
				unset($repeated[$i]);
			}
		}
	}

	sort($repeated);

	return $repeated;
}
?>
