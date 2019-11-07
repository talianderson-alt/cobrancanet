<?php

namespace CobrancaNet\Validador; 


class Validador{
 

	public function valorOriginalTitulo( $value ){
		if( strpos( $value, '.') === false ){
	 		$this->erros[] = "Valor esperado: 0.00, recebito: " . $value;
	 		return false;
	 	}

		return true;
	}

	/**
	*/
	public function dataVencimentoTitulo($value ){

		 $dataAtual = new \DateTime();

		 try{
		 	if( !($value instanceof \DateTime)){
		 		$dataVencimentoTitulo = \DateTime::createFromFormat("d.m.Y", $value);
		 	}else{
		 		$dataVencimentoTitulo = $value;
		 	}
		 	
		 }catch(\Exception $ex){
		 	$this->erros[] = $ex->getMessage();
		 	return false;
		 }


		 if( $dataVencimentoTitulo < $dataAtual){
		 	$this->erros[] = "A data de vencimento do título não pode ser menor que a data atual";
		 	return false;
		 }

		 $this->dadosTitulo['dataVencimentoTitulo'] = $dataVencimentoTitulo;
		 return true;
	}

	public function codigoTipoInscricaoPagador( $value ){
		if( !in_array($value, [1,2])) {
			$this->erros = "Permitido apenas 1 - CPF, ou 2 - CNPJ";
			return false;
		}

		return true;
	}

	public function numeroInscricaoPagador( $value){
		$codigoTipoInscricaoPagador = @$this->dadosTitulo['codigoTipoInscricaoPagador'];
		if( $codigoTipoInscricaoPagador == 1 )
		{
			if(!$this->valida_cpf( $value )){
				$this->erros = "CPF inválido";
				return false;
			}
		}

		if( $codigoTipoInscricaoPagador == 2){
			if(!$this->Utils->valida_cnpj($value)){
				$this->erros = "CNPJ inválido";
				return false;
			}
		}

		return true;
	}

	public function postarTituloCorreio($value){
		if(in_array( $value, [0,1]))
		{
			
		 
			// cliente informa que será nossa responsabilidade
			// a emissão do titulo pelo correio
			// Nesse caso, devemos garantir que as informações de enderço
			// estejam corretas
			if( $value == 1 )
			{

				$numeroCepPagador 		= "";
				$siglaUfPagador			= "";
				$nomeMunicipioPagador	= "";

				if( !array_key_exists('numeroCepPagador', $this->dadosTitulo )){
					$this->erros[] = sprintf("Campo obrigatório não informado [numeroCepPagador]"); 
				}else{
					$numeroCepPagador 		= $this->dadosTitulo['numeroCepPagador'];
				}

				if( !array_key_exists('siglaUfPagador', $this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatório não informado [siglaUfPagador]");
				}else{
					$siglaUfPagador 		= $this->dadosTitulo['siglaUfPagador'];
				}

				if( !array_key_exists('nomeMunicipioPagador', $this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatório não informado [nomeMunicipioPagador]");
				}else{
					$nomeMunicipioPagador	= $this->dadosTitulo['nomeMunicipioPagador'];
				} 
				 

			} 
			return true; 
		}else{ 
			$this->erros = "Permitido apenas 1 - sim, ou 0 - não";
			return false;
		}
	}

	public function numeroCepPagador($value){
		if( strlen($value) != 8 ){
			$this->erros = "Cep inválido";
			return false;
		}
		return true;
	}

	public function siglaUfPagador($value){
		if( strlen($value) != 2 ){
			$this->erros = "Formato inválido";
			return false;
		}

		return true;
	}

	public function textoEnderecoPagador($value){
		return true;
	}

	public function codigoTipoInscricaoAvalista($value){
		if(!in_array( $value, [1,2])){
			$this->erros ="Valores permitidos 1 - CPF, 2 - CNPJ";
			return false;
		}

		return true;
	}

	public function numeroInscricaoAvalista($value){

		if( array_key_exists('codigoTipoInscricaoAvalista', $this->dadosTitulo))
		{
			$codigoTipoInscricaoAvalista = $this->dadosTitulo['codigoTipoInscricaoAvalista'];

			if( $codigoTipoInscricaoAvalista == 1 ){
				if( !$this->valida_cpf( $value )){
					$this->erros[] = "CPF avalista inválido";
					return false;
				}
			}else if( $codigoTipoInscricaoAvalista == 2 ){
				if( !$this->valida_cnpj($value)){
					$this->erros[] = "CNPJ avalista inválido";
					return false;
				}
			}

			return true;
		}

		return true;
	}

	public function codigoTipoTitulo($value){
		$validos = array(
			1 => 'CHEQUE',
			2 => 'DUPLICATA-MERCANTIL',
			4 => 'DUPLICATA-SERVIÇO',
			6 => 'DUPLICATA-RUAL',
			7 => 'LETRA-DE-CAMBIO',
			12 => 'NOTA-PROMISSORIA',
			13 => 'NOTA-PROMISSORIA-RURAL',
			17 => 'RECIBO',
			19 => 'NOTA-DE-DEBITO',
			23 => 'DIVIDA-ATIVA-UNIAO'
		);

		if( !array_key_exists($value, $validos )){
			$this->erros[] = sprintf("[%d] Valor não permitido", $value);
			return false;
		}

		return true;
	}

	public function codigoTipoDescontoTitulo( $value){
		if( in_array( $value, [0,1,2])){ 
			if( $value == 1 )
			{
				// desconto do tipo valor
				if(!array_key_exists('valorDescontoTitulo', $this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatório não informado [valorDescontoTitulo]");
				}
			}else if( $value == 2 ){
				if(!array_key_exists('percentualDescontoTitulo', $this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatorio não informado [percentualDescontoTitulo]");
				}
			} 

			return true;
		}else{
			$this->erros[] = "Tipo de desconto inválido";
			return false;
		}
	}

	public function dataDescontoTitulo($value){

		if( $value == "D")
		{
			$dataVencimentoTitulo = self::getValue( $this->dadosTitulo, 'dataVencimentoTitulo', 'date');

			if( $dataVencimentoTitulo != null ){
				$this->dadosTitulo['dataDescontoTitulo'] = $dataVencimentoTitulo;
				return true;
			}
		}

		try{
			if( !($value instanceof \DateTime)){
				$dataDescontoTitulo = \DateTime::createFromFormat("d.m.Y", $value);
			}else{
				$dataDescontoTitulo = $value;
			}
			
		}catch(\Exception $ex){
			$this->erros[] = $ex->getMessage();
			return false;
		}

		$dataAtual = new \DateTime();

		if( $dataDescontoTitulo < $dataAtual ){
			$this->erros[] = "A data de desconto não pode ser menor que a data atual";
			return false;
		}
		if(array_key_exists('dataVencimentoTitulo', $this->dadosTitulo)){
			try{

				if( !($this->dadosTitulo['dataVencimentoTitulo'] instanceof \DateTime)){
					$dataVencimentoTitulo = \DateTime::createFromFormat( "d.m.Y", $this->dadosTitulo['dataVencimentoTitulo']);
				}else{
					$dataVencimentoTitulo = $this->dadosTitulo['dataVencimentoTitulo'];
				}
				
			}catch(\Exception $ex){
				$this->erros[] = "Falha ao comparar data de desconto com a data de vencimento do título. Favor verifique o valor informado no campo [dataVencimentoTitulo]";
				return false;
			}

			if( $dataDescontoTitulo > $dataVencimentoTitulo ){
				$this->erros[] = "A data do desconto não pode ser maior que a data de vencimento do título";
				return false;
			} 

		}else{
			$this->erros[] = "Falha ao comparar data de desconto com a data de vencimento do título. Favor verifique o valor informado no campo [dataVencimentoTitulo]";
			return false;
		}

		$this->dadosTitulo['dataDescontoTitulo'] = $dataDescontoTitulo;

		return true;
	}

	public function valorDescontoTitulo($value){

		$codigoTipoDescontoTitulo = self::getValue( $this->dadosTitulo, 'codigoTipoDescontoTitulo');

		if(array_key_exists('valorOriginalTitulo', $this->dadosTitulo) &&
		$codigoTipoDescontoTitulo == 1){
			$valorOriginalTitulo = $this->dadosTitulo['valorOriginalTitulo'];

			if( floatval($value) >= floatval($valorOriginalTitulo) ){
				$this->erros[] = "O valor do desconto não pode ser maior ou igual o valor do título ";

				$this->erros[] = sprintf("[valor título = %.2f, valor do desconto = %.2f]", $valorOriginalTitulo, $value);
				return false;
			}

			return true;
		}else{
			$this->dadosTitulo['valorDescontoTitulo'] = "";
		}
		return true;
	}

	public function percentualDescontoTitulo($value){
		$value = floatval($value);
		$percent = $value/100;
		$codigoTipoDescontoTitulo = self::getValue( $this->dadosTitulo, 'codigoTipoDescontoTitulo');

		if( array_key_exists('valorOriginalTitulo', $this->dadosTitulo ) &&
			$codigoTipoDescontoTitulo == 2){
			$valorOriginalTitulo = $this->dadosTitulo['valorOriginalTitulo'];
			$desconto = ($valorOriginalTitulo * $percent );

			if( $desconto > $valorOriginalTitulo ){
				$this->erros[] = "O valor do desconto não pode ser maior ou igual o valor do título ";

				$this->erros[] = sprintf("[valor título = %.2f, valor do desconto = %.2f]", $valorOriginalTitulo, $desconto);

				return false;
			} 
			$this->dadosTitulo['percentualDescontoTitulo'] = $percent;	
		}else{
			$this->dadosTitulo['percentualDescontoTitulo'] = "";						
		}

		return true;
	}

	public function dataCadastroTitulo($value){
		try{
			$dataCadastro = \DateTime::createFromFormat("d.m.Y", $value);
		}catch(\Exception $ex){
			$this->erros[] = $ex->getMessage();
			return false;
		}

		$dataAtual	  = new \DateTime();

		if( $dataCadastro > $dataAtual ){
			$this->erros[] = "A data de cadastro do título não pode ser maior que a data atual";
			return false;
		}
		$this->dadosTitulo['dataCadastroTitulo'] = $dataCadastro;

		return true;
	}

	public function codigoTipoJuroMoraTitulo($value){
		if( in_array( $value, [0,1,2])){ 
			// juros do tipo valor
			if( $value == 1 ){
				if(!array_key_exists('valorJuroMoraTitulo', $this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatório não informado [valorJuroMoraTitulo]");
				}
			}
			// juros do tipo percentual
			else if( $value == 2){
				if(!array_key_exists('percentualJuroMoraTitulo', $this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatório não informado [percentualJuroMoraTitulo]");
				}
			}

			if(!array_key_exists('dataJuroMoraTitulo',$this->dadosTitulo)){
				$this->erros[] = sprintf("Campo obrigatório não informado [dataJuroMoraTitulo]");
			}

			return true;
		}else{
			$this->erros[] = "Tipo de juros inválido";
			return false;
		}
	}

	public function dataJuroMoraTitulo($value){
		$dataVencimentoTitulo = self::getValue( $this->dadosTitulo , 'dataVencimentoTitulo', 'date');

		if( $value == "D+1")
		{
			if(  $dataVencimentoTitulo != null ){
				$dPlusOne = clone $dataVencimentoTitulo;
				$dPlusOne->modify("+1 day");
				$this->dadosTitulo['dataJuroMoraTitulo'] = $dPlusOne;
				return true;
			}

		}
 

		if( !($value instanceof \DateTime)){ 
			try{
				$dataJuroMoraTitulo = \DateTime::createFromFormat('d.m.Y', $value);
			}catch(\Exception $ex){
				$this->erros[] = $ex->getMessage();
				return false;
			}
		}else{
			$dataJuroMoraTitulo = $value;
		}

		if(!array_key_exists('dataVencimentoTitulo', $this->dadosTitulo)){
			$this->erros[] = "Falha ao comparar a data de incidência de juros com a data de vencimento do título";
			return false;
		}

		if( !($this->dadosTitulo['dataVencimentoTitulo'] instanceof \DateTime) ){
			try{
				$dataVencimentoTitulo = \DateTime::createFromFormat('d.m.Y', $this->dadosTitulo['dataVencimentoTitulo']);
			}catch(\Exception $ex){
				$this->erros[] = "Falha ao comparar a data de incidencia de juros com a data de vencimento do título";
				return false;
			}
		}else{
			$dataVencimentoTitulo = $this->dadosTitulo['dataVencimentoTitulo'];
		}

		if( $dataJuroMoraTitulo  <= $dataVencimentoTitulo ){
			$this->erros[] = "A data de incidência de juros não pode ser menor ou igual a data de vencimento do título";
			return false;
		}

		$this->dadosTitulo['dataJuroMoraTitulo'] = $dataJuroMoraTitulo;
		return true;
	}

	public function valorJuroMoraTitulo($value){
		$valorJuroMoraTitulo = floatval($value);
		return true;
	}

	public function percentualJuroMoraTitulo($value){
		return true;
	}

	public function codigoTipoMulta( $value){
		if( in_array( $value, [0,1,2])){ 
			if( $value == 1 ){
				if( !array_key_exists('valorMultaTitulo',$this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatório não informado [valorMultaTitulo]");
				}							
			}
			else if( $value == 2){
				if( !array_key_exists('percentualMultaTitulo', $this->dadosTitulo)){
					$this->erros[] = sprintf("Campo obrigatório não informado [percentualMultaTitulo]");								
				}
			}

			if( !array_key_exists('dataMultaTitulo', $this->dadosTitulo)){
				$this->erros[] = sprintf("Campo obrigatório não informado [dataMultaTitulo]");
			}

			return true;
		}else{
			$this->erros[] = "Tipo de multa inválido";
			return false;
		}
	}

	public function dataMultaTitulo($value){
		$dataVencimentoTitulo = self::getValue( $this->dadosTitulo , 'dataVencimentoTitulo', 'date');

		$codigoTipoMulta = self::getValue($this->dadosTitulo, 'codigoTipoMulta');

		if( !in_array($codigoTipoMulta, [0,1,2]) || $codigoTipoMulta == 0 ){
			$this->dadosTitulo['dataMultaTitulo'] = null;
			return true;
		}

		if( $value == "D+1")
		{
			if( $dataVencimentoTitulo != null ){
				$dPlusOne = clone $dataVencimentoTitulo;
				$dPlusOne->modify("+1 day");
				$this->dadosTitulo['dataMultaTitulo'] = $dPlusOne;
				return true;
			}
		}

		if(array_key_exists('codigoTipoMulta', $this->dadosTitulo)){
			$codigoTipoMulta = $this->dadosTitulo['codigoTipoMulta'];

			if( $codigoTipoMulta == 0)
				return true;
		}


		try{ 
			if( !($value instanceof \DateTime)){
				$dataMultaTitulo = \DateTime::createFromFormat("d.m.Y", $value);
			}else{
				$dataMultaTitulo = $value;
			}
			
		}catch(\Exception $ex){
			$this->erros[] =  $ex->getMessage();
			return false;
		}

		if( array_key_exists('dataVencimentoTitulo', $this->dadosTitulo)){ 
			try{
				if(!($this->dadosTitulo['dataVencimentoTitulo'] instanceof \DateTime)){
				$dataVencimentoTitulo = \DateTime::createFromFormat("d.m.Y", $this->dadosTitulo['dataVencimentoTitulo']);
				}else{
					$dataVencimentoTitulo = $this->dadosTitulo['dataVencimentoTitulo'];
				}
			}catch(\Exception $ex){
				$this->erros[] = "Falha ao comparar com a data de vencimento do título. Verifique o vencmento informado no campo [dataVencimentoTitulo]";
				return false;
			}
		}

		if( $dataMultaTitulo <= $dataVencimentoTitulo ){
			$this->erros[] = "A data de aplicação da multa não pode ser menor ou igual a data de vencimento do título";
			return false;
		}
		$this->dadosTitulo['dataMultaTitulo'] = $dataMultaTitulo;

		return true;
	}

	public function valorMultaTitulo($value){
		$codigoTipoMulta = self::getValue($this->dadosTitulo, 'codigoTipoMulta');

		if( in_array( $codigoTipoMulta, [0,1,2]) )
		{
			if( $codigoTipoMulta == 0 || $codigoTipoMulta == 2){
				$this->dadosTitulo['valorMultaTitulo'] = "";
			}
		}else{
			$this->dadosTitulo['valorMultaTitulo'] = "";
		}

		return true;
	}



	public function percentualMultaTitulo($value){
		$codigoTipoMulta = self::getValue($this->dadosTitulo, 'codigoTipoMulta');

		if( in_array( $codigoTipoMulta, [0,1,2]) )
		{
			if( $codigoTipoMulta == 0 || $codigoTipoMulta == 1){
				$this->dadosTitulo['percentualMultaTitulo'] = "";
			}
		}else{
			$this->dadosTitulo['percentualMultaTitulo'] = "";
		}

		return true;
	}

	public function nomePagador($value){
		if( strlen( $value ) > 30 ){
			$this->erros[] = "Campo não pode ter mais que 30 caracteres";
			return false;
		}
		return true;
	}

	public function dataEmissaoTitulo($value){
		try{
			$dataEmissaoTitulo = \DateTime::createFromFormat('d.m.Y', $value);
		}catch(\Exception $ex){
			$this->erros[] = $ex->getMessage();
			return false;
		}

		$dataAtual = new  \DateTime();

		if( $dataEmissaoTitulo > $dataAtual ){
			$this->erros[] = "A data de emissão não pode ser maior que a data atual";
			return false;
		}

		$this->dadosTitulo['dataEmissaoTitulo'] = $dataEmissaoTitulo;
		return true;
	}

	public function descricaoTitulo($value){
		if( strlen( $value ) > 30 ){
			$this->erros[] = "Limite de caracteres 30";
			return false;
		}
		return true;
	}

	public function setDadosTitulo( array $itens = []){
		$this->dadosTitulo = $itens;
	}

	public function validar( $callback ){
		foreach( $this->_inputValidator as $key => $item ){
			if( !array_key_exists($key, $this->dadosTitulo) && $item['obrigatorio']){
				$this->erros[] = sprintf("Campo obrigatório não informado [%s]",
					$key);
				continue;
			}

			$value = $this->dadosTitulo[$key];
			if( $item['obrigatorio'] && trim( $value ) == "")
			{
				$this->erros[] = sprintf("Campo obrigatório não pode ficar em branco [%s]",
					$key);
				continue;
			}
 
			if(method_exists(  $this , $key ) ){
				$result = $this->$key( 
					$value
				);
			}			
		}

		$numErros = count($this->erros);
		if( $numErros > 0){
			$type = 'error';
		}else{
			$type = 'success';
		}

		$result = [
			'type' => $type,
			'erros' => $this->erros 
		];

		if( $type == 'success'){
			$result['data'] = $this->dadosTitulo;
		}

		$callback( $result );		
	}


	private $dadosTitulo;
	private $erros = [];
	private $_inputValidator;

	public function __construct(){
		$this->_inputValidator  = [

			'valorOriginalTitulo' => [
				'obrigatorio' => true  
			],

			'dataVencimentoTitulo' => [
				'obrigatorio' => true 
			],

			'codigoTipoInscricaoPagador' => [
				'obrigatorio' => true 
			],

			'numeroInscricaoPagador' => [
				'obrigatorio' => true 
			],

			'postarTituloCorreio' => [
				'obrigatorio' => true 
			],

			'numeroCepPagador' => [
				'obrigatorio' => false 
			],

			'siglaUfPagador' => [
				'obrigatorio' => false 
			],

			'textoEnderecoPagador' => [
				'obrigatorio' => true 
			],

			'codigoTipoInscricaoAvalista' => [
				'obrigatorio' => false 
			],

			'numeroInscricaoAvalista' => [
				'obrigatorio' => false 
			],

			'codigoTipoTitulo' => [
				'obrigatorio' => true 
			],

			'codigoTipoDescontoTitulo' => [
				'obrigatorio' => true 
			],

			'dataDescontoTitulo' => [
				'obrigatorio' => false 
			],

			'valorDescontoTitulo' => [
				'obrigatorio' => false 
			],

			'percentualDescontoTitulo' => [
				'obrigatorio' => false 
			],

			'dataCadastroTitulo' => [
				'obrigatorio' => false 
			],

			'codigoTipoJuroMoraTitulo' =>[
				'obrigatorio' => false 
			],

			'dataJuroMoraTitulo' => [
				'obrigatorio' => false 
			],

			'valorJuroMoraTitulo' => [
				'obrigatorio' => false 
			],

			'percentualJuroMoraTitulo' => [
				'obrigatorio' => false 
			],

			'codigoTipoMulta' => [
				'obrigatorio' => false 
			],

			 
			'dataMultaTitulo' => [
				'obrigatorio' => false 
			],

			'valorMultaTitulo' => [
				'obrigatorio' => false
			],

			'percentualMultaTitulo' => [
				'obrigatorio' => false 
			],

			'nomePagador' => [
				'obrigatorio' => true 
			],

			'dataEmissaoTitulo' => [
				'obrigatorio' => true 
			],

			'descricaoTitulo' => [
				'obrigatorio' => true 
			]
		];
	}

	public static function getValue( $array, $key, $type = null ){
	 

		//dd( $key);
		if( array_key_exists($key, $array)){

			$value = $array[$key]; 
			switch($type){
				case "date":{
					try{

						if( !($value instanceof \DateTime))
							$value = \DateTime::createFromFormat("d.m.Y", $value);

						return $value;
					}catch(\Exception $ex){
						return null;
					}

					return $value;
					break;
				}
				default:{
					return $value;
				}
			}


		}else{

			return null;
		}
	}

	public function valida_cpf($cpf = null) {

		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}

		// Elimina possivel mascara
		$cpf = preg_replace("/[^0-9]/", "", $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		
		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			
			for ($t = 9; $t < 11; $t++) {
				
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}

			return true;
		}
	}

	public function valida_cnpj($cnpj) {
        // Deixa o CNPJ com apenas números
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Garante que o CNPJ é uma string
        $cnpj = (string) $cnpj;

        // O valor original
        $cnpj_original = $cnpj;

        // Captura os primeiros 12 números do CNPJ
        $primeiros_numeros_cnpj = substr($cnpj, 0, 12);

        /**
         * Multiplicação do CNPJ
         *
         * @param string $cnpj Os digitos do CNPJ
         * @param int $posicoes A posição que vai iniciar a regressão
         * @return int O
         *
         */
        if (!function_exists('multiplica_cnpj')) {

            function multiplica_cnpj($cnpj, $posicao = 5) {
                // Variável para o cálculo
                $calculo = 0;

                // Laço para percorrer os item do cnpj
                for ($i = 0; $i < strlen($cnpj); $i++) {
                    // Cálculo mais posição do CNPJ * a posição
                    $calculo = $calculo + ( $cnpj[$i] * $posicao );

                    // Decrementa a posição a cada volta do laço
                    $posicao--;

                    // Se a posição for menor que 2, ela se torna 9
                    if ($posicao < 2) {
                        $posicao = 9;
                    }
                }
                // Retorna o cálculo
                return $calculo;
            }

        }

        // Faz o primeiro cálculo
        $primeiro_calculo = multiplica_cnpj($primeiros_numeros_cnpj);

        // Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
        // Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
        $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 : 11 - ( $primeiro_calculo % 11 );

        // Concatena o primeiro dígito nos 12 primeiros números do CNPJ
        // Agora temos 13 números aqui
        $primeiros_numeros_cnpj .= $primeiro_digito;

        // O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
        $segundo_calculo = multiplica_cnpj($primeiros_numeros_cnpj, 6);
        $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 : 11 - ( $segundo_calculo % 11 );

        // Concatena o segundo dígito ao CNPJ
        $cnpj = $primeiros_numeros_cnpj . $segundo_digito;

        // Verifica se o CNPJ gerado é idêntico ao enviado
        if ($cnpj === $cnpj_original) {
            return true;
        }
    }

}