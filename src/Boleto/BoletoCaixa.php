<?php

namespace CobrancaNet\Boleto;


class BoletoCaixa extends Boleto{

	 public function __construct(){
	 	parent::__construct();
	 	$this->setBanco("104");
	 	$this->setMoeda('9');
	 }


	 public function getNossoNumero(){
	 	$banco = $this->getBanco();
	 	$carteira = $this->getCarteira();

	 	$result = "";
	 	if( $carteira == "1" || $carteira == "RG"){
	 		$result .= "1";
	 	}else if( $carteira == "2" || $carteira == "SR"){
	 		$result .= "2";
	 	}

	 	$result .= "4"; // emissão própria

	 	$sequencial = $this->getSequencial();

	 	$result .= str_pad(
	 		$sequencial, 
	 		15, 
	 		'0', 
	 		STR_PAD_LEFT
	 	); 

	 	return $result;
	 }

	 public function getCodigoDeBarras(){
	 	$result = "";

	 	
	 	$result .= $this->getBanco();							//3
	 	$result .= $this->getMoeda();							//1
	 	//$result .= "X"; // DV 
	 	$result .= $this->getFatorVencimento(); 				//4
	 	$valor  =  number_format($this->getValor(),2,'','');
	 	$valor  =  str_pad( $valor, 10,'0', STR_PAD_LEFT);
	 	 
	 	$result .= $valor;										//10

	 	 
	 	$campo_livre = "";
	 	$cedente = $this->getCedente();							
	 	$cedente_dv = $this->getCedenteDv();					

	 	$campo_livre .= str_pad( $cedente, 6, '0', STR_PAD_LEFT);//6 
	 	$campo_livre .= $cedente_dv;							 //1
	 	$nosso_numero = $this->getNossoNumero();

	 	//sequencial 1
	 	$campo_livre .= substr( $nosso_numero, 2, 3);			//3
	  
	 	//constante 1
	 	$campo_livre .= substr( $nosso_numero, 0, 1);			//1
	 	//sequencial 2
	 	$campo_livre .= substr( $nosso_numero, 5, 3);			//3
	 	// constante 2
	 	$campo_livre .= substr( $nosso_numero, 1, 1);			//1
	 	// sequencial 3
	 	$campo_livre .= substr( $nosso_numero, 8, 9);			//9
	 	
	 	 
	 	$dv_campo_livre = self::calcula_dv_mod11($campo_livre);
	 	$campo_livre .= $dv_campo_livre;						//1
	 	$result .= $campo_livre;								 
 
	 	$dv = self::calcula_dv_mod11($result);

	 	$result = substr_replace($result, $dv, 4, 0);
 
	 	return $result; 
	 }

	 
}