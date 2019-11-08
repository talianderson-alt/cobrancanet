<?php
require_once __DIR__ . "/vendor/autoload.php";

use CobrancaNet\CobrancaNet;
use Spipu\Html2Pdf\Html2Pdf;

 
session_start();
$user_id="KLyWAAMuWeUEWLMhpdPWIqDnbkQMUGifShCTiOOFsjJOuWxkzMHIDLwfxNsRTcynJAHsOWyIFHXBeTmehtmlGjRDxKWRmUFxWMplintouRpamcETXqGeaYiYiFpWauSxHJjqxdfswWSizYDWOJBphj";
	$secret ="ttyuWiXaByTpqxCozIedsIafRtcNPmFJhDFEldenczeSxgHwomZhuANNtpbJdhSKkYOXBtKetoxqUFmKrMrnMGBGxdPaKjlwIBSKueooSmgorSAkfsZszbzwEPXPAILIKeSGJIwcucRnwRZcLyUKaTHekfukoGtzlMFuWBYQdqFZJeBUdXgDqnicTdNIkHHWUMRqNpIrgNRpsSKWprahfJKznYHYfPuAcMqqDAijNAaHTldKdEsJODJCbQ";
$CobrancaNet = new CobrancaNet( $user_id, $secret);
$CobrancaNet->setAmbiente(COBRANCANET_PRDC);
$CobrancaNet->set('numeroDocumento', '014164')
->set('fk_id_convenio',12)
->set('fk_id_taxa', 1)
->set('fk_id_cliente',1)
->set('codigoConvenio', '3330023NJD')
->set('dataVencimentoTitulo', '30.11.2019')
->set('valorOriginalTitulo', '545.65')
->set('codigoTipoInscricaoPagador', '1')
->set('nomePagador','ALANA PRISCILLA')
->set('dataEmissaoTitulo', '06.11.2019')
->set('codigoTipoTitulo', '1')
//->set('descricaoTitulo', 'CONTA DE INTERNET')
->set('codigoTipoDescontoTitulo',0)
->set('postarTituloCorreio', 0)
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

$CobrancaNet->executar(function( $result ){ 
	echo "<pre>";
	//var_dump($result); 
});

$CobrancaNet->getPdfDocument(null); 