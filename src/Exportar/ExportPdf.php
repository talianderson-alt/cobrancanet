<?php

namespace CobrancaNet\Exportar;

use Spipu\Html2Pdf\Html2Pdf;

class ExportPdf extends Html2Pdf{

	private $dadosBoleto;
	private $layout;

	public function setDadosBoleto( $dadosBoleto ){
		$this->dadosBoleto = $dadosBoleto;
	}

	public function __construct(){
		parent::__construct('P','A4','fr',true,'UTF-8',array(0, 0, 0, 0));
		$this->layout = file_get_contents("layouts/boleto.ctp");

	}

	public function write(){ 
		$codigoDeBarras = $this->dadosBoleto->codigoDeBarras;

		$dadosBoleto = $this->dadosBoleto;
		$dadosConvenio = $dadosBoleto->convenio;

		$dataVencimento = new \DateTime( $dadosBoleto->dataVencimentoTitulo);
		$dataCadastrotitulo = new \DateTime( $dadosBoleto->dataCadastroTitulo);

		$this->layout = str_replace("{linhaDigitavel}", $dadosBoleto->linhaDigitavel, $this->layout);
		$this->layout = str_replace("{numeroDocumento}", $dadosBoleto->numeroDocumento, $this->layout);
		$this->layout = str_replace("{header}", $dadosConvenio->header, $this->layout);
		$this->layout = str_replace("{dataProcessamento}", $dataCadastrotitulo->format('d/m/Y'), $this->layout);
	    $this->layout = str_replace("{nomePagador}", $dadosBoleto->nomePagador, $this->layout);
		$this->layout = str_replace("{textoEnderecoPagador}", $dadosBoleto->textoEnderecoPagador, $this->layout);
		$this->layout = str_replace("{siglaUfPagador}",$dadosBoleto->siglaUfPagador, $this->layout);
		$this->layout = str_replace("{nomeMunicipioPagador}", $dadosBoleto->nomeMunicipioPagador, $this->layout);
		$this->layout = str_replace("{valorTitulo}", $dadosBoleto->valorOriginalTitulo, $this->layout);
		$this->layout = str_replace("{numeroCepPagador}", $dadosBoleto->numeroCepPagador, $this->layout);
		$this->layout = str_replace("{agencia}", $dadosConvenio->agencia, $this->layout);
		$this->layout = str_replace("{cedente}", $dadosConvenio->cedente,$this->layout);
		$this->layout = str_replace("{nossoNumero}", $dadosBoleto->nossoNumero, $this->layout);
		$this->layout = str_replace("{dataVencimentoTitulo}", $dataVencimento->format('d/m/Y'), $this->layout);
		$this->layout = str_replace("{numeroInscricaoPagador}", $dadosBoleto->numeroInscricaoPagador, $this->layout);
		$this->layout = str_replace("{valorOriginalTitulo}", number_format($dadosBoleto->valorOriginalTitulo,2,',','.'), $this->layout);
		$this->layout = str_replace("{especie}","", $this->layout);
	    $this->layout = str_replace("{aceite}", $dadosBoleto->codigoAceiteTitulo, $this->layout);
		$this->layout = str_replace("{data_debito}", $dataCadastrotitulo->format('d/m/Y'), $this->layout);
		$this->layout = str_replace("{mensagem1}", $dadosConvenio->mensagem1, $this->layout);
		$this->layout = str_replace("{mensagem2}", $dadosConvenio->mensagem2, $this->layout);
		$this->layout = str_replace("{mensagem3}", $dadosConvenio->mensagem3, $this->layout);
		$this->layout = str_replace("{mensagem4}", $dadosConvenio->mensagem4, $this->layout);
		$this->layout = str_replace("{carteira}", $dadosConvenio->carteira, $this->layout);
		$this->layout = str_replace("{nomeCedente}", $dadosConvenio->nomecedente, $this->layout);
		$this->layout = str_replace("{codigoDeBarras}", $dadosBoleto->codigoDeBarras, $this->layout);


		$this->writeHTML($this->layout);
	}
}