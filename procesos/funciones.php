<?php
	function maxCaracter($texto, $cant){        
    	$texto = substr($texto, 0,$cant);
    	return $texto;
	}
	function truncateFloat($number, $digitos){
	    $raiz = 10;
	    $multiplicador = pow ($raiz,$digitos);
	    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
	    return number_format($resultado, $digitos);
	 
	}
?>