<?php
require_once __DIR__ . "/vendor/autoload.php";

use CobrancaNet\CobrancaNet;
use CobrancaNet\Exportar\ExportPdf;
  

session_start();
$user_id="APaQWlktYSkXNozkzDbFoZOuWLAoJpAKFbccMNXkgHIuwIfwMHBBhQxDdxsnmsysUbWhosSUBbPxkwtxDuzkMwopthdgbcawDxerpxNqZeoJaiGeeFPqCEhwmLdNoEKrBokqmziLdYUEGcjlizdlDL";
	$secret ="YcUtdFFjXtWwJTNbcErxaODDFzNAuRySuSMYZRIwMfsWzGycLqamFdqKcELYXJqRdEqCXAyjfqGfyFHKwhxBLnMosZMPiDiMIZOfaNPFFWlEbsPYbMamBmbtMnKursIASXgslwzqSkuueKSFYssagUUsIfoBZxCrUilGekyyWssAELGdFzDlTZfdETedRhWnPHtusrsOlmPqyWTEUYqpxWSCqygJfDxwLrrEjkTWYjNXFhbbGRQEokHfio";
$CobrancaNet = new CobrancaNet( $user_id, $secret);
$CobrancaNet->setAmbiente(COBRANCANET_PRDC);
$CobrancaNet->set('numeroDocumento', '014164')   
->set('codigoConvenio', '3330023NJD')
->set('valorOriginalTitulo', '6545.65')
->set('dataVencimentoTitulo','30.11.2019')
->set('codigoTipoInscricaoPagador', '1')
->set('nomePagador','ALANA PRISCILLA')
->set('dataEmissaoTitulo', '06.11.2019')
->set('codigoTipoTitulo', '1')
->set('descricaoTitulo', 'CONTA DE INTERNET')
->set('codigoTipoDescontoTitulo',0)
->set('postarTituloCorreio', 1)
->set('textoEnderecoPagador','Q 5 ON D') 
->set('dataCadastroTitulo','01.11.2019')
->set('codigoTipoInscricaoAvalista','1')
->set('nomeAvalistaTitulo','TALIANDERSON')
->set('numeroInscricaoAvalista','03734431107') 
->set('codigoAceiteTitulo','N')
->set('numeroCepPagador','72726111')
->set('siglaUfPagador','DF')
->set('nomeMunicipioPagador','BRASILIA')
->set('nomeBairroPagador','BRAZLANDIA')
->set('permitirRecebimentoParcial','0') 
->set('dataDescontoTitulo','15.11.2019') 
->set('valorDescontoTitulo','2.00')
->set('percentualDescontoTitulo','2.00')
->set('codigoModalidadeTitulo','1')
->set('codigoTipoMulta','2')
->set('dataMultaTitulo','21.12.2019')
->set('valorMultaTitulo','2.00')
->set('percentualMultaTitulo','2.00')
->set('codigoTipoJuroMoraTitulo','0')
->set('dataJuroMoraTitulo','21.12.2019')
->set('valorJuroMoraTitulo','2.00')
->set('percentualJuroMoraTitulo','2.00')
->set('numeroInscricaoPagador', '03734431107');
/*
$CobrancaNet->executar(function($result ) use ($CobrancaNet){ 

	if( $result->type == 'success'){

		//var_dump($result->data);
		$CobrancaNet->getPdfDocument( function( $boletoPdf ){
			//sleep(3);
			$file = $boletoPdf->output('/dodc.pdf','S'); 
			header("Content-type:application/pdf");
			header("Content-Disposition:attachment;filename=test.pdf");
			echo $file;
		});
	}
});*/


$result = $CobrancaNet->query([
	'nossoNumero' => '15715930000000431',
	'codigoDeBarras' => '00195808900006545650000001571593000000042217'
]);

var_dump($result);