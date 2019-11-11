<?php
require_once __DIR__ . "/vendor/autoload.php";

use CobrancaNet\CobrancaNet;
use CobrancaNet\Exportar\ExportPdf;
  

session_start();
 
$CobrancaNet = new CobrancaNet( COBRANCANET_USER_ID, COBRANCANET_SECRET);
$CobrancaNet->setAmbiente(COBRANCANET_PRDC);
$CobrancaNet
->set('codigoConvenio', '3330023NJD')
->set('valorOriginalTitulo', '625.21')
->set('dataVencimentoTitulo','30.12.2019')
->set('codigoTipoInscricaoPagador', '1')
->set('numeroInscricaoPagador', '03734431107')
->set('nomePagador','JUNIOR SOUZA')
//->set('dataEmissaoTitulo', '06.11.2019')
//->set('codigoTipoTitulo', '1')
//->set('descricaoTitulo', 'CONTA DE INTERNET') 
//->set('postarTituloCorreio', 1)
->set('textoEnderecoPagador','NUC. RURAL ALEX. GUSMÃO') 
//->set('dataCadastroTitulo','01.11.2019')
->set('codigoTipoInscricaoAvalista','1')
->set('nomeAvalistaTitulo','TALIANDERSON')
->set('numeroInscricaoAvalista','03734431107') 
->set('codigoAceiteTitulo','N')
->set('numeroCepPagador','72726111')
->set('siglaUfPagador','DF')
->set('nomeMunicipioPagador','BRASILIA')
->set('nomeBairroPagador','BRAZLANDIA')
//->set('codigoTipoDescontoTitulo',0)
//->set('permitirRecebimentoParcial','0') 
//->set('dataDescontoTitulo','D') 
//->set('valorDescontoTitulo','2.00')
->set('percentualDescontoTitulo','2.00')
->set('codigoModalidadeTitulo','1')
->set('numeroDocumento', '03314164')  
//->set('codigoTipoMulta','1')
//->set('dataMultaTitulo','21.12.2019')
//->set('valorMultaTitulo','2.00')
//->set('percentualMultaTitulo','2.00')
//->set('codigoTipoJuroMoraTitulo','0')
//->set('dataJuroMoraTitulo','21.12.2019')
//->set('valorJuroMoraTitulo','2.00')
//->set('percentualJuroMoraTitulo','2.00')
;
 
$CobrancaNet->executar( function( $CobrancaNet ){
	//var_dump($this->getDadosTitulo());
	$erros = $CobrancaNet->getErros();

	if( count( $erros ) == 0){
		//var_dump($CobrancaNet->getDadosTitulo());
		$CobrancaNet->exportarBoletoPdf( function( $pdf ){
			$pdf->output();
		});
	}else{
		echo "<pre>";
		var_dump($erros);
	}
});
 
 /*
$consulta = array(
	'nossoNumero' => '15718790000000183'
);

$CobrancaNet->query( $consulta,  function($CobrancaNet){

		if( count($CobrancaNet->getErros()) == 0){
			echo "<pre>";
			var_dump($CobrancaNet->getDadosTitulo());
		}else{
			var_dump($CobrancaNet->getErros());
		}
});
*/