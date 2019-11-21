<?php

namespace CobrancaNet\Boleto;

class BoletoSicoob extends Boleto{

	public function __construct(){
	 	parent::__construct();
	 	$this->setBanco("756");
	 	$this->setMoeda('9');
	 }


	 public function getNossoNumero(){
	 	$sequencial = $this->getSequencial();
	 	$nosso_numero = str_pad( $sequencial, 8 , '0', STR_PAD_LEFT);
	 	return $nosso_numero;
	 }

	 public function getCodigoDeBarras(){ 
	 	$banco 			= $this->getBanco();							//3
	 	$moeda 			= $this->getMoeda();							//1
	 	$dv 			= "";											//1			
	 	$fator_venc 	= $this->getFatorVencimento();					//4
	 	$valor  		= number_format($this->getValor(),2,'','');
	 	$valor 			= str_pad( $valor, 10,'0', STR_PAD_LEFT);		//10
	 	$carteira 		= $this->getCarteira();							//1
	 	$cooperativa 	= $this->getCooperativa();
	 	$cooperativa  	= str_pad( $cooperativa, 4,'0', STR_PAD_LEFT);	//4
	 	$modalidade 	= $this->getModalidade();			
	 	$modalidade 	= str_pad( $modalidade,2,'0',STR_PAD_LEFT);		//2
	 	$cedente 		= $this->getCedente();
	 	$cedente 		= str_pad($cedente, 7, '0', STR_PAD_LEFT);		//7
	 	$nosso_numero   = $this->getNossoNumero();	 					//8
	 	$parcela 		= 2;//$this->getParcela();
	 	$parcela 		= str_pad($parcela,3,'0', STR_PAD_LEFT);		//3

	 	$barcode = $banco . $moeda . $dv . $fator_venc .$valor . $carteira  . $cooperativa.$modalidade.$cedente.$nosso_numero.$parcela;
	 
	 	$dv = self::calcula_dv_mod11($barcode);
	 	$result = substr_replace($barcode, $dv, 4, 0);
	 	return $result;
	 }
}