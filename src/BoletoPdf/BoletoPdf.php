<?php

namespace CobrancaNet\Pdf;

use Spipu\Html2Pdf\Html2Pdf;

class BoletoPdf extends Html2Pdf{

	private $dadosBoleto;

	public function setDadosBoleto( $dadosBoleto ){
		$this->dadosBoleto = $dadosBoleto;
	}

	public function __construct(){
		parent::__construct();

	}

	public function write(){ 
		$codigoDeBarras = $this->dadosBoleto->codigoDeBarras;
		$linhaDigitavel = $this->dadosBoleto->linhaDigitavel;
		$this->writeHTML("$linhaDigitavel");
	}
}