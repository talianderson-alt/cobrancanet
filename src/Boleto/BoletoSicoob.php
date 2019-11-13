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
	 	$banco 			= $this->getBanco();
	 	$moeda 			= $this->getMoeda();
	 	$dv 			= "";
	 	$fator_venc 	= $this->getFatorVencimento();
	 	$valor 			= $this->getValor();
	 	$valor 			= str_pad( $valor, 10,'0', STR_PAD_LEFT);
	 	$carteira 		= $this->getCarteira();
	 	$cooperativa 	="4126";
	 	$modalidade 	= $this->getModalidade();
	 	$cedente 		= $this->getCedente();
	 	$nosso_numero   = $this->getNossoNumero();	 	
	 	$parcela 		= "001";

	 	$barcode = $banco . $moeda . $dv . $fator_venc . $valor . $carteira . $cooperativa . $cedente .$nosso_numero . $parcela;

	 	$dv = self::calcula_dv_mod11($barcode);
	 	$result = substr_replace($barcode, $dv, 4, 0);
	 	return $result;
	 }
}