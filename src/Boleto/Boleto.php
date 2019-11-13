<?php
namespace CobrancaNet\Boleto;
use CobrancaNet\Boleto\Exceptions\DataVencimentoEmBrancoException;
use Cake\I18n\Date;

class Boleto implements BoletoInterface{
 

	public function __construct(){

	}


	public function getCodigoDeBarras(){
		return "";
	}

	public function getLinhaDigitavel(){
	 	$codigodebarras  = $this->getCodigoDeBarras();

	 	$Digita1 = substr($codigodebarras,0,4).substr($codigodebarras,19,5);
        $Digita2 = substr($codigodebarras,24,10);
        $Digita3 = substr($codigodebarras,34,10);
        $Digita4 = substr($codigodebarras,4,1);
        $Digita5 = substr($codigodebarras,5,14);
            // coloca o DV
        $Digita1 = $Digita1.$this->calcula_dv_mod10($Digita1);
        $Digita2 = $Digita2.$this->calcula_dv_mod10($Digita2);
        $Digita3 = $Digita3.$this->calcula_dv_mod10($Digita3);
            // coloca os pontos
        $Digita1 = substr($Digita1,0,5).'.'.substr($Digita1,5,5);
        $Digita2 = substr($Digita2,0,5).'.'.substr($Digita2,5,6);
        $Digita3 = substr($Digita3,0,5).'.'.substr($Digita3,5,6);
            // monta linha digitavel com pontos e espacos
        $linhadigitavel = $Digita1.'  '.$Digita2.'  '.$Digita3.'  '.$Digita4.'  '.$Digita5;

        return $linhadigitavel;
	 }

	public function getFatorVencimento(){

		$fator = 0;
		$venc = $this->getVencimento();
		if(!is_null($venc) && ($venc instanceof Date)){
			$inicial = mktime(0,0,0, '10', '7', '1997');
			$final   = mktime(0,0,0, $venc->format('m'), $venc->format('d'), $venc->format('Y'));
			 
			$fator = $final - $inicial;
			$segundos = 24 * 60 * 60;
			$fator = ceil($fator/$segundos);
		}else{
			throw new DataVencimentoEmBrancoException("Data de vencimento em branco");
		}
		return $fator;
	}

	public function setValor( $valor ){
		$this->valor = $valor;
		return $this;
	}

	public function getValor(){
		return $this->valor;
	}

	public function setCarteira($value){
		$this->carteira = $value;
		return $this;
	}

	public function getCarteira(){
		return $this->carteira;
	}

	public function setVencimento($value){
		$this->vencimento = $value;
		return $this;
	}

	public function getVencimento(){
		return $this->vencimento;
	}

	public function getNossoNumero(){
		return $this->nossoNumero;
	}

	public function getNossoNumeroDv(){
		return $this->nossoNumeroDv;
	}

	public function setNossoNumero($numero, $dv = null){
		$this->nossoNumero = $numero;

		if( is_null($dv)){
			$this->nossoNumeroDv = self::calcula_dv_mod11($numero);
		}else{
			$this->nossoNumeroDv = $dv;
		}


		return $this;
	}

	public function setCedente( $cedente, $cedente_dv){
		$this->cedente = $cedente;
		$this->cedente_dv = $cedente_dv;
		return $this;
	}

	public function getCedente(){
		return $this->cedente;
	}

	public function getCedenteDv(){
		return $this->cedente_dv;
	}

	public function setMoeda( $value ){
		$this->moeda = $value;
		return $this;
	}

	public function getMoeda(){
		return $this->moeda;
	}

	public function setNumeroDocumento($value){
		$this->numeroDocumento = $value;
		return $this;
	}

	public function getNumeroDocumento(){
		return $this->numeroDocumento;
	}

	public function setBanco($value){
		$this->banco = $value;
		return $this;
	}

	public function getBanco(){
		return $this->banco;
	}

	public function setAgencia($agencia, $agencia_dv){
		$this->agencia = $agencia;
		$this->agencia_dv = $agencia_dv;
		return $this;
	}

	public function getAgencia(){
		return $this->agencia;
	}

	public function getAgenciaDv(){
		return $this->agencia_dv;
	}

	public function setDataDocumento($value){
		$this->dataDocumento = $value;
		return $this;
	}

	public function getDataDocumento(){
		return $this->dataDocumento;
	}

	public function setDataProcessamento($value){
		$this->dataProcessamento = $value;
		return $this;
	}

	public function getDataProcessamento(){
		return $this->dataProcessamento;
	}

	public function setEspecie($value){
		$this->especie = $value;
		return $this;
	}

	public function getEspecie(){
		return $this->especie;
	}

	public function setSequencial($value){
		$this->sequencial = $value;
		return $this;
	}

	public function getSequencial(){
		return $this->sequencial;
	}

	 public function calcula_dv_mod10( $num )
    {
        $num = strrev( $num );
        $soma = 0;
        $mult = 2;

        for( $i = 0; $i < strlen($num); $i++)
        {
            $nro = $num[$i] * $mult;
            if( $nro > 9 )
            {
                $soma += $nro - 9;
            }else
            {
                $soma += $nro;
            }

            if( $mult == 2 )
            {
                $mult = 1;
            }
            else if( $mult == 1)
            {
                $mult = 2;
            }
        }

        $dv = 10 - ($soma%10);

        if( $dv == 10)
            $dv = 0;

        return $dv;
    }

    public static function calcula_dv_mod11( $num )
    {
        $num = strrev($num);    //O comando STRREV inverte a string. Ex: 123 vira 321
        $soma = 0;
        $mult = 2;
        for($i=0;$i<strlen($num);$i++)
        {
            $nro = $num[$i] * $mult;
            $soma += $nro;
            $mult++;
            if($mult > 9)
                $mult = 2;
        }
        $dc = 11 - ($soma%11);
        if($dc == 10 || $dc == 11 || $dc == 0)
            $dc = 1;

        return $dc;
    }

    public static function calcula_dv_mod11c1($num)
    {
        $num = strrev( $num );
        $soma = 0;
        $mult = 2;
        for( $i = 0; $i < strlen( $num); $i++ )
        {
            $nro = $num[$i] * $mult;
            $soma += $nro;
            $mult++;

            if( $mult > 9 )
            {
                $mult = 2;
            }
        }

        $dc = 11 - ($soma%11);

        if( $dc > 9 )
        {
            $dc = 0;
        }

        return $dc;
    }

    public function setConvenio($convenio, $convenio_dv){
    	$this->convenio = $convenio;
    	$this->convenio_dv = $convenio_dv;
    	return $this;
    }

    public function getConvenio(){
    	return $this->convenio;
    }

    public function getConvenioDv(){
    	return $this->convenio_dv;
    }

    public function setContaCorrente( $conta, $dv ){
    	$this->conta_corrente = $conta;
    	$this->conta_corrente_dv = $dv;
    	return $this;
    }

    public function getContaCorrente(){
    	return $this->conta_corrente;
    }

    public function getContaCorrenteDv(){
    	return $this->conta_corrente_dv;
    }

    public function setModalidade( $modalidade ){
    	$this->modalidade = $modalidade;
    	return $this;
    }

    public function getModalidade(){
    	return $this->modalidade;
    }

	private $valor;
	private $vencimento;
	private $carteira; 
	private $linhaDigitave;
	private $codigoDeBarras;
	private $cedente;
	private $cedente_dv;
	private $moeda;
	private $numeroDocumento;
	private $banco;
	private $agencia;
	private $agencia_dv;
	private $convenio;
	private $convenio_dv;
	private $dataDocumento;
	private $dataProcessamento;
	private $especie;
	private $sequencial;
	private $conta_corrente;
	private $conta_corrente_dv;
	private $modalidade;

	protected $nossoNumero;
	protected $nossoNumeroDv;

	public static function createBoleto( $debito ){
        $convenio = $debito['convenio'];
        $banco    = $convenio['banco'];
 
        switch($banco){
            case "104":{
                $boleto = new BoletoCaixa(); 
                break;
            }
            case "001":{
                $boleto = new BoletoBB();
                break;
            }
            
            case "756":{
            	$boleto = new BoletoSicoob();
            	$boleto->setBanco($banco);
            	break;
            }
            case ("033" || "353" || "008"):{
                $boleto = new BoletoSantander();
                $boleto->setBanco($banco);
                break;
            }
            default:{
                throw new \Exception('Banco não suportado.');
            }
        }

        $boleto->setValor( $debito['valor'] );
        $boleto->setCedente( 
            $convenio['cedente'],
            $convenio['cedente_dv']
        );
        $boleto->setAgencia(
            $convenio['agencia'],
            $convenio['agencia_dv']
        );

        $boleto->setConvenio(
            $convenio['convenio'],
            $convenio['convenio_dv']
        );

        $boleto->setContaCorrente(
            $convenio['conta_corrente'],
            $convenio['conta_corrente_dv']
        );
         
        $boleto->setVencimento(new Date($debito['vencimento']));
        $boleto->setSequencial($debito['id_debito']);
        $boleto->setCarteira($convenio['carteira']);
        

        $boleto->setMoeda($convenio['moeda']);

        return $boleto;
    }

}