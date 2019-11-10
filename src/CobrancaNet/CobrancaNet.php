<?php 

namespace CobrancaNet;
use CobrancaNet\Validador\Validador;
use CobrancaNet\Exportar\ExportPdf;


class CobrancaNet{

	/**
	* @var $user_id
	*/
	private $user_id;
	private $secret;
	private $ambiente;
	private $curl;
 	private $numeroDocumento;
 	private $descricaoTitulo;
 	private $dadosTitulo;
 	private $dadosBoleto;

 	public function setNumeroDocumento( $val ){
 		$this->numeroDocumento = $val;
 		return $this;
 	}

 	public function getNumeroDocumento(){
 		return $this->numeroDocumento;
 	}

 	public function setAmbiente( $ambiente ){ 
 		if( in_array($ambiente, [COBRANCANET_PRDC,COBRANCANET_HMLG])){
 			$this->ambiente = $ambiente;
 			return true;
 		}
 		return false;
 	}


	public function __construct( $user_id, $secret ){
		$this->user_id = $user_id;
		$this->secret = $secret;
		//$this->ambiente = PRODUCAO;
		$this->dadosTitulo = array();
	}

	public function set( $key , $value){
		$this->dadosTitulo[$key] = $value;
		return $this;
	}

	public function initCurl(){
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

	public function executar( $function ){

		$validator = new Validador(); 
		$validator->setDadosTitulo($this->dadosTitulo); 
		$validator->validar( function( $result  ) use (   $function  )  {
			 

			if( $result['type'] == 'success' ){
				$token = $this->getToken(); 
				if( is_object( $token ) ){
					if( $token->type == 'success' ){
						$this->initCurl();
						curl_setopt($this->curl, CURLOPT_URL, $this->ambiente['registro']);
						curl_setopt($this->curl, 
							CURLOPT_POSTFIELDS, 
							$result['data']
						);

						curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
						    "Accept: application/json" ,
						    "Authorization: Bearer " . $token->data->token  ,
						    "Origin: ". "http://". $_SERVER["HTTP_HOST"]
						)); 

						$request = curl_exec($this->curl); 
						   
						$request = json_decode($request);

						if( is_object( $request ) ){
							if( isset( $request->data )){
								$this->dadosBoleto = $request->data;
							}
							$function( $request);
						}else{
							$function( $request );
						}
					}else{
						$function( (object) array(
							'type' => 'error',
							'message' => $token->msg,
							'data' => null
						));
					}
				}else{
					$function( (object) array(
						'type' => 'error',
						'message' => 'Falha ao recuperar o token',
						'data' => null
					)); 
				}
			}else{
				$function( (object) $result );
			} 
		});  
	}


	public function query( $dados ){
		$token = $this->getToken();
		if( $token->type == 'success' ){
			$this->initCurl();
			curl_setopt($this->curl, CURLOPT_URL, $this->ambiente['consulta']);
			curl_setopt($this->curl, 
				CURLOPT_POSTFIELDS, 
				$dados
			);

			curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
			    "Accept: application/json" ,
			    "Authorization: Bearer " . $token->data->token  ,
			    "Origin: ". "http://". $_SERVER["HTTP_HOST"]
			)); 

			$request = curl_exec( $this->curl );
			 
			$request = json_decode($request);

			curl_close($this->curl);
			return $request;
		}else{
			return null;
		}
	}


	public function getPdfDocument( $callback ){
		$boletoPdf = new ExportPdf();
		$boletoPdf->setDadosBoleto($this->dadosBoleto);
		$boletoPdf->write();
		return $callback( $boletoPdf );
	}


}