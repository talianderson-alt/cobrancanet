<?php
namespace CobrancaNet\Boleto;

class BoletoBB extends Boleto{

	public function __construct(){
	 	parent::__construct();
	 	$this->setBanco("001");
	 	$this->setMoeda('9');
	 }

	public function getNossoNumero(){


		if(!is_null($this->nossoNumero)){
			return $this->nossoNumero;
		}


		$sequencial 	= $this->getSequencial();
		$convenio 		= $this->getConvenio();
		$carteira 	    = $this->getCarteira();

		$result 		= "";

		switch(strlen($convenio)){
			case 4:{
				$result .= $convenio;
				$result .= str_pad( $sequencial, 7, '0', STR_PAD_LEFT);
				break;
			}
			case 6:{

				if( in_array($carteira, [16,18])){
					$result .= str_pad( $sequencial, 17,'0', STR_PAD_LEFT);
				}else{
					$result .= $convenio;
					$result .= str_pad( $sequencial, 5, '0', STR_PAD_LEFT);
				}

				break;
			}
			case 7:{
				$result .= $convenio;
				$result .= str_pad( $sequencial, 10, '0', STR_PAD_LEFT);
				break;
			}
			default:{
				throw new \Exception('Convênio inválido');
			}
		} 

		$this->nossoNumero = $result;
		$dv = parent::calcula_dv_mod11($result);
		$this->nossoNumeroDv = $dv;
		
	 	return $result;
	 }	

	 public function getCodigoDeBarras(){
	 	
	 	$convenio 		= $this->getConvenio(); 
	 	$banco  		= $this->getBanco();
	 	$moeda  		= $this->getMoeda();
	 	$fator  		= $this->getFatorVencimento();
	 	$valor  		=  number_format($this->getValor(),2,'','');
	 	$valor  		=  str_pad( $valor, 10,'0', STR_PAD_LEFT);
	 	$campo_livre	= "";
	 	switch( strlen( $convenio) ){
	 		// convenio de 4 posições
	 		case 4:{
	 			$campo_livre .= $this->getNossoNumero();
	 			$campo_livre .= $this->getAgencia();
	 			$campo_livre .= $this->getContaCorrente(); //"00000000"; // conta corrente
	 			$campo_livre .= $this->getCarteira();
	 			break;
	 		}
	 		case 6:{

	 			/*
	 			$campo_livre .= $this->getNossoNumero();
	 			$campo_livre .= $this->getAgencia();
	 			$campo_livre .= $this->getContaCorrente(); //"00000000"; // conta corrente

	 			$carteira = $this->getCarteira();
	 			if(in_array( $carteira, [16,18])){
	 				$campo_livre .= "21";
	 			}else{
	 				$campo_livre .= $carteira;
	 			}*/
	 			$carteira = $this->getCarteira();
	 			if(in_array($carteira, [16,18])){
	 				$campo_livre .= $convenio;
	 				$campo_livre .= $this->getNossoNumero();
	 				$campo_livre .= "21";
	 			}else{
	 				$campo_livre .= $this->getNossoNumero();
	 				$campo_livre .= $this->getAgencia();
	 				$campo_livre .= $this->getContaCorrente();
	 				$campo_livre .= $carteira;
	 			}
	 			
	 			break;
	 		}
	 		case 7:{
	 			$campo_livre .= "000000";
	 			$campo_livre .= $this->getNossoNumero();
	 			$campo_livre .= $this->getCarteira();
	 			break;
	 		}
	 		default:{
	 			throw new \Exception("Convênio inválido");
	 		}
	 	}

	 	$result = "";
	 	$result .= $banco;
	 	$result .= $moeda;
	 	$result .= "";
	 	$result .= $fator;
	 	$result .= $valor;
	 	$result .= $campo_livre;

	 	$dv = self::calcula_dv_mod11($result);
	 	$result = substr_replace($result, $dv, 4, 0);
	 	return $result; 
	 }
}