<?php
namespace CobrancaNet\Boleto;

class BoletoSantander extends Boleto{

	public function __construct(){
	 	parent::__construct();
	 	$this->setBanco("033");
	 	$this->setMoeda('9');
	 }

	public function getNossoNumero(){

		$sequencial = $this->getSequencial();
		$numero = "";
		switch( $this->getBanco() ){
			case "033":{
				$numero = str_pad( $sequencial, 12, '0', STR_PAD_LEFT);
				break;
			}
			case "353":{
				$numero = "00000";
				$numero .= str_pad( $sequencial, 7, '0', STR_PAD_LEFT);
				break;
			}
			case "008":{
				$numero = "0000";
				$numero .= str_pad( $sequencial, 8, '0', STR_PAD_LEFT);
				break;
			}
			default:{
				throw new \Exception("Falha ao gerar nosso numero. Santander");
			}
		}

		return $numero;
	 }	

	 public function getCodigoDeBarras(){
	 	
	 	$convenio 		= $this->getConvenio(); 

	 	$banco  		= $this->getBanco();
	 	$moeda  		= $this->getMoeda();
	 	$cedente 		= $this->getCedente();
	 	$carteira 		= $this->getCarteira();
	 	$fator  		= $this->getFatorVencimento();
	 	$valor  		=  number_format($this->getValor(),2,'','');
	 	$valor  		=  str_pad( $valor, 10,'0', STR_PAD_LEFT);
	 	$nosso_numero   = $this->getNossoNumero();
	 	$dv_nosnum      = Boleto::calcula_dv_mod11($nosso_numero);
	 	$campo_livre	= "";
	 	 
	 	$result = $banco;
	 	$result .= $moeda;
	 	$result .= "";
	 	$result .= $fator;
	 	$result .= $valor;

	 	$result .= "9";
	 	$result .= str_pad( $cedente, 7, '0', STR_PAD_LEFT);
	 	$result .= $nosso_numero;
	 	$result .= $dv_nosnum;
	 	$result .= "0"; // IOF
	 	$result .= str_pad($carteira, 3, '0', STR_PAD_LEFT);
 
	 	$dv = self::calcula_dv_mod11($result);
	 	$result = substr_replace($result, $dv, 4, 0);
	 	return $result; 
	 }
}