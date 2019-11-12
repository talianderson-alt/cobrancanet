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

				$filename = sprintf("arquivo%s.ret",strtotime(date("Y-m-d H:i:s")));
				$file = fopen($filename,"w");

				foreach( $dados as $key => $value ){
					// seu código aqui 

					$descricaoTitulo			= @$value->descricaoTitulo;
					$numeroDocumento			= @$value->numeroDocumento;
					$valorOriginalTitulo		= @$value->valorOriginalTitulo;
					$dataVencimentoTitulo		= @$value->dataVencimentoTitulo;
					$codigoModalidadeTitulo 	= @$value->codigoModalidadeTitulo;
					$nossoNumero				= @$value->nossoNumero;
					$codigoDeBarras				= @$value->codigoDeBarras;
					$linhaDigitavel				= @$value->linhaDigitavel;
					// informações de desconto
					$codigoTipoDescontoTitulo	= @$value->codigoTipoDescontoTitulo;
					$dataDescontoTitulo			= @$value->dataDescontoTitulo;

					// informações de juros
					$codigoTipoJuroMora			= @$value->codigoTipoJuroMoraTitulo;
					$dataJuroMoraTitulo			= @$value->dataJuroMoraTitulo;
					$valorJuroMoraTitulo		= @$value->valorJuroMoraTitulo;
					$percentualJuroMoraTitulo	= @$value->percentualJuroMoraTitulo;

					// informações de multa
					$codigoTipoMulta			= @$value->codigoTipoMulta;

					$codigoAceiteTitulo			= @$value->codigoAceiteTitulo;
					$codigoTipoTitulo 			= @$value->codigoTipoTitulo;
					$permitirRecebimentoParcial	= @$value->permitirRecebimentoParcial;
					$codigoTipoInscricaoPagador = @$value->codigoTipoInscricaoPagador;
					$numeroInscricaoPagador		= @$value->numeroInscricaoPagador;
					$nomePagador				= @$value->nomePagador;
					$numeroCepPagador			= @$value->numeroCepPagador;
					$siglaUfPagador				= @$value->siglaUfPagador;
					$nomeMunicipioPagador		= @$value->nomeMunicipioPagador;
					$nomeBairroPagador			= @$value->nomeBairroPagador;
					$textoEnderecoPagador		= @$value->textoEnderecoPagador;
					$codigoTipoInscricaoAvalista= @$value->codigoTipoInscricaoAvalista;
					$nomeAvalistaTitulo			= @$value->nomeAvalistaTitulo;
					$numeroInscricaoAvalista	= @$value->numeroInscricaoAvalista;
					$dataCadastroTitulo			= @$value->dataCadastroTitulo;
					$dataEmissaoTitulo			= @$value->dataEmissaoTitulo;
					$postarTituloCorreio		= @$value->postarTituloCorreio;
					fwrite($file,sprintf("nossoNumero=%s\n",$nossoNumero));
				}
				fclose($file);
				
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
