<?php
require_once __DIR__ . "/vendor/autoload.php";

use CobrancaNet\RetornoCobrancaNet;

 
$retorno = new RetornoCobrancaNet(COBRANCANET_USER_ID, COBRANCANET_SECRET);
$retorno->setAmbiente(COBRANCANET_PRDC);
if( isset($_POST["TOKEN_RETORNO"]) )
{
	$_token_verification = $_POST["TOKEN_RETORNO"]; 
	if( $_token_verification == COBRANCANET_TOKEN_RETORNO ){ 

		$retorno->executar( function( $result ){
			
			if( count($result->getErros()) == 0){
				$dados = $result->getDadosTitulos();

				foreach( $dados as $key => $value ){
					// seu código aqui
				}

				return die(json_encode([
					'type' => 'success',
					'message' => 'Arquivo retorno baixado com sucesso',
					'data' => count($dados)
				]));
			}else{
				return die(json_encode([
					'type' => 'error',
					'message' => $result->getErros(),
					'data' => null
				]));
			}
		});  
	}else{
		return die(json_encode([
			'type' => 'error',
			'message' => 'Token de retorno incompatível',
			'data' => null
		]));
	}
}
/*
$retorno->executar( function( $result ){ 
	if( count($result->getErros()) == 0){
		$dados = $result->getDadosTitulos();
		echo "<pre>";
		var_dump($dados);
	}else{
		var_dump($result->getErros());
	}
});*/