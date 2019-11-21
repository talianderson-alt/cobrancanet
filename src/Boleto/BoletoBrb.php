<?php

namespace CobrancaNet\Boleto;

class BoletoBrb extends Boleto{

	public function __construct(){
	 	parent::__construct();
	 	$this->setBanco("070");
	 	$this->setMoeda('9');
	 }


	 public function getNossoNumero(){

	 	$carteira 	= $this->getCarteira();
	 	$sequencial = $this->getSequencial();
	 	$sequencial = str_pad( $sequencial, 6, '0', STR_PAD_LEFT);
	 	$banco 		= $this->getBanco();
	 	$banco 		= str_pad( $banco, 3, '0', STR_PAD_LEFT);
	 	//$dv1 		= '1';
	 	//$dv2 		= '2';

	 	$nosnum = $carteira.$sequencial.$banco;
	 	return $nosnum;
	 }

	 public function getCodigoDeBarras(){ 
	 	$banco 			= $this->getBanco();							//3
	 	$moeda 			= $this->getMoeda();							//1
	 	$dv 			= "";											//1			
	 	$fator_venc 	= $this->getFatorVencimento();					//4
	 	$valor  		= number_format($this->getValor(),2,'','');
	 	$valor 			= str_pad( $valor, 10,'0', STR_PAD_LEFT);		//10

	 	$zeros 			= "000";										//3
	 	$agencia 		= $this->getAgencia();
	 	$agencia 		= str_pad( $agencia, 3, '0', STR_PAD_LEFT); 	//3
	 	$cc 			= $this->getContaCorrente();
	 	$cc 			= str_pad( $cc, 7, '0', STR_PAD_LEFT); 			//7

	 	$nosnum 		= $this->getNossoNumero();
	 	/*$carteira 		= $this->getCarteira(); 						//1
	 	$sequencial 	= $this->getSequencial();
	 	$sequencial 	= str_pad( $sequencial, 6, '0', STR_PAD_LEFT);	//6
	 	$banco 			= $this->getBanco();
	 	$banco 			= str_pad( $banco, 3, '0', STR_PAD_LEFT); 		//3
	 	$dv1 			= '1'; 											//1
	 	$dv2 			= '0'; 											//1
		*/

	 	$barcode = $banco . $moeda . $dv . $fator_venc .$valor;
	 	$chave 	 = $zeros . $agencia . $cc . $nosnum;

	 	$dv1 = $this->calc_mod_10( $chave );
	 	$dv2 = $this->calc_mod_11( $chave, $dv1);

	 	$chave .= $dv1;
	 	$chave .= $dv2;

	 	$barcode .= $chave;

	 	$dv = self::calcula_dv_mod11($barcode);
	 	$result = substr_replace($barcode, $dv, 4, 0);
	 	return $result;
	 }

	 private function calc_mod_10( $num ){

	 	$num = strrev( $num );
	 	$soma = 0;
	 	$mult = 2;
	 	for( $i = 0; $i < strlen($num); $i++ )
	 	{
	 		$nro = $num[$i] * $mult;
	 		$soma += $nro;

	 		if( $mult == 2 )
	 			$mult = 1;
	 		else
	 			$mult = 2;
	 	} 

	 	if( $soma > 9){
	 		$soma -= 9;
	 	}

	 	$resto = ($soma % 10);

	 	if( $resto == 0){
	 		return $resto;
	 	}

	 	if( $resto > 0){
	 		$resto = 10 - $resto;
	 	}

	 	return $resto;
	 }


	 private function calc_mod_11( $num, &$d1 )
	 {
	 	 
	 	$num = strrev( $num . $d1);
	 	$size = strlen($num);
	 	$soma = 0;
	 	$mult = 2;

	 	for( $i = 0; $i < $size; $i++ )
	 	{
	 		$nro = $num[$i] * $mult;
	 		$soma += $nro;
	 		$mult++;

	 		if( $mult > 7 ){
	 			$mult = 2;
	 		}
	 	}

	 	$resto = ($soma % 11);


	 	if( $resto == 1)
	 	{
	 		$d1 += 1;

	 		if( $d1 == 10 )
	 		{
	 			$d1 = 0;
	 		}

	 		$d2 = $this->calc_mod_11( $num, $d1 );
	 		return $d2;
	 	}


	 	if( $resto == 0){
	 		return $resto;
	 	}

	 	if( $resto > 1){
	 		$resto = 11 - $resto;
	 	}

	 	return $resto; 
	 }
}