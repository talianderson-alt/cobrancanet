<?php

namespace CobrancaNet\Boleto;

interface BoletoInterface{

	public function getNossoNumero();
	public function getCodigoDeBarras();
	public function getLinhaDigitavel();
	public function getFatorVencimento();
	
}