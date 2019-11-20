<?php
namespace CobrancaNet\Boleto;

class BoletoCobranca extends Boleto{

	public function __construct(){
	 	parent::__construct();
	 	$this->setBanco("000");
	 	$this->setMoeda('9');
	 }

	 public function getNossoNumero()
	 {

	 	$sequencial = $this->getSequencial();
	 	$sequencial = str_pad( $sequencial, 8, '0', STR_PAD_LEFT);
	 	return $sequencial;
	 }

	 public function getCodigoDeBarras()
	 {

	 	$banco 			= $this->getBanco();
	 	$moeda 			= $this->getMoeda();
	 	$dv 			= "";
	 	$fator 			= $this->getFatorVencimento(); 
	 	$valor 			= $this->getValor();
	 	$valor 			= number_format($valor,2,'','');
	 	$valor 			= str_pad( $valor, 10, '0', STR_PAD_LEFT);


	 	// campo livre
	 	$carteira 		= $this->getCarteira(); 						// 1
	 	$cedente 		= $this->getCedente(); 							
	 	$cedente 		= str_pad( $cedente, 6, '0', STR_PAD_LEFT);		// 6
	 	$conta 			= $this->getContaCorrente(); 					
	 	$conta 			= str_pad( $conta, 7, '0', STR_PAD_LEFT); 		// 7
	 	$nosnum 		= $this->getNossoNumero(); 						// 8
	 	$parcela 		= "001"; 										// 3

	 	$barcode = "";
	 	$barcode .= $banco;
	 	$barcode .= $moeda; 
	 	$barcode .= $dv;
	 	$barcode .= $fator;
	 	$barcode .= $valor;
	 	$barcode .= $carteira;
	 	$barcode .= $cedente;
	 	$barcode .= $conta;
	 	$barcode .= $nosnum;
	 	$barcode .= $parcela;

	 	$dv = self::calcula_dv_mod11($barcode);
	 	$barcode = substr_replace($barcode, $dv, 4, 0);

	 	return $barcode;
	 }
 
}