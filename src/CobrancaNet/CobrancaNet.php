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
 		if( is_array( $ambiente )){
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
			'Connection: Keep-Alive',
			'Content-Length: 0', 
			'Authorization: Basic ' . base64_encode( $this->user_id . ":" . $this->secret)
		)); 
		$result = curl_exec($this->curl); 
		curl_close( $this->curl );
		return json_decode($result);
	}

	private $error = [];

	public function executar( callable $callback ){
		
		$validator = new Validador(); 
		$validator->setDadosTitulo($this->dadosTitulo); 
		$resultValidate = $validator->validar(function( $result  ) { 

			if( $result['type'] == 'success')
				return $result['data'];

			$this->error = $result['message'];
			return null; 
		});  
   
 		if( $resultValidate != null )
 		{
 			$this->dadosTitulo = $resultValidate;
 			$tokenResponse = $this->getToken();

 			if( is_object($tokenResponse))
 			{
 				$type 		= $tokenResponse->type;
 				$msg 		= $tokenResponse->msg;
 				$token		= $tokenResponse->data->token;

 				if( $type != 'success')
 				{
 					$this->error[] = $msg;
 					return $callback($this);
 				}else{

 					// inicia a transmissão dos dados do boleto
 					$this->initCurl();

 					// configura URL para registro do titulo
 					curl_setopt($this->curl, 
 						CURLOPT_URL, 
 						$this->ambiente['registro']
 					);

 					// cabeçalho da requisição
 					curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
					    "Accept: application/json" ,
					    "Authorization: Bearer " . $token ,
					    "Origin: ". "http://". $_SERVER["HTTP_HOST"]
					)); 

 					// prepara os dados para serem lançados
					curl_setopt($this->curl, 
						CURLOPT_POSTFIELDS, 
						$this->getDadosTitulo()
					);


					$requestResponse = curl_exec($this->curl); 
					 
					$requestResponse = json_decode($requestResponse);

					//die(var_dump($requestResponse));
					curl_close($this->curl);

					if( is_object($requestResponse))
					{
						$typeResponse = @$requestResponse->type;
						$message	  = @$requestResponse->message;
						$dados 	  	  = @$requestResponse->data;


						if( $typeResponse != 'success'){
							$this->error[] = $message;
							return $callback($this);
						}else{
							$this->dadosTitulo = $dados;
							return $callback($this);
						} 
					}else{
						$this->error[] = "Falha na requisição da resposta";
						return $callback($this);
					}
 				}
 			}else{
 				$this->error[] = "Houve uma falha durante a recuperação do token";
 				return $callback($this);
 			}
 		} 

		return $callback($this);
	}


	public function getErros(){
		return $this->error;
	}

	public function getDadosTitulo(){
		return $this->dadosTitulo;
	}

	public function query( $dados,  callable $callback ){
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
			//return $request;
			if( is_object($request)){ 
				if( $request->type != 'success'){
					$this->error[] = $request->message;
					return $callback($this);
				}else{

					if( count( $request->data ) > 0){
						$this->dadosTitulo = $request->data;
					}
					
					return $callback($this);
				}
			}else{
				$this->error[] = "Falha na recuperação dos dados";
				return $callback($this);
			}
		}else{
			$this->error[] = "Falha na recuperação do token";
			return $callback($this);
		}
	}


	public function exportarBoletoPdf( callable $callback ){
		$boletoPdf = new ExportPdf();
		$boletoPdf->setDadosBoleto($this->dadosTitulo);
		$boletoPdf->write();
		return $callback( $boletoPdf );
	} 
}