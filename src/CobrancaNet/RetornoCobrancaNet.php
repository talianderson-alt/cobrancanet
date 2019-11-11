<?php
namespace CobrancaNet;

class RetornoCobrancaNet{

	private $user_id;
	private $secret;
	private $curl;
	private $ambiente;

	public function __construct( $user_id, $secret ){
		$this->user_id = $user_id;

		$this->secret = $secret;
	}

	public function setAmbiente( $ambiente ){
		$this->ambiente = $ambiente;
	}

	private function initCurl(){
		$this->curl = curl_init(); 
		curl_setopt($this->curl, CURLOPT_POST, true);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
	}

	public function getToken(){

		$this->initCurl(); 
		curl_setopt($this->curl, CURLOPT_URL, $this->ambiente['token']);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Authorization: Basic ' . base64_encode( $this->user_id . ":" . $this->secret)
		));

		$result = curl_exec($this->curl); 
		curl_close( $this->curl );
		return json_decode($result);
	}

	public function executar( callable $callback ){
		$tokenResponse = $this->getToken();


		if( $tokenResponse->type == 'success')
		{
			$token = $tokenResponse->data->token;
			$this->initCurl();

			// configura URL para registro do titulo
			curl_setopt($this->curl, 
				CURLOPT_URL, 
				$this->ambiente['retorno']
			);

			// cabeçalho da requisição
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			    "Accept: application/json" ,
			    "Authorization: Bearer " . $token ,
			    "Origin: ". "http://". $_SERVER["HTTP_HOST"]
			)); 

			$requestResponse = curl_exec($this->curl); 
			$requestResponse = json_decode($requestResponse);			
			curl_close($this->curl);

			if( $requestResponse->type == 'success')
			{				
				$this->erros = [];
				$this->dadosTitulo = $requestResponse->data;
				return $callback($this);
			}else{
				$this->erros[] = $requestResponse->message;
				return $callback($this);
			}

			return $callback ($this);
		}else{
			$this->erros[] = $tokenResponse->msg;
			return $callback( $this );
		}
	}

	public function getErros(){
		return $this->erros;
	}

	
	public function getDadosTitulos(){
		return $this->dadosTitulo;
	}

	private $erros = [];
	private $dadosTitulo;
}