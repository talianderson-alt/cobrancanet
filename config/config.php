<?php

define("COBRANCANET_PRDC", array(
	'token' => 'http://www.cobranca.net.br/auth/token',
	'registro' => 'http://www.cobranca.net.br/auth/validar',
	'consulta' => 'http://www.cobranca.net.br/auth/consultar',
	'retorno' => 'http://www.cobranca.net.br/auth/retorno'
));

define("COBRANCANET_HMLG", array(
	'token' => 'http://hmg.cobranca.net.br/auth/token',
	'registro' => 'http://hmg.cobranca.net.br/auth/validar',
	'consulta' => 'http://hmg.cobranca.net.br/auth/consultar',
	'retorno' => 'http://hmg.cobranca.net.br/auth/retorno'
));

define("LOCAL", array(
	'token' => 'http://localhost/apicobrancanet/auth/token',
	'registro' => 'http://localhost/apicobrancanet/auth/validar',
	'consulta' => 'http://localhost/apicobrancanet/auth/consultar',
	'retorno' => 'http://localhost/apicobrancanet/auth/retorno'
));

// user_id necessário para gerar o token das requisições
define(
	"COBRANCANET_USER_ID", 
	"APaAGlktYSkXNozkzDbFoZOuWLAoJpAKFbccMNXkgHIuwIfwMHBBhQxDdxsnmsysUbWhosSUBbPxkwtxDuzkMwopthdgbcawDxerpxNqZeoJaiGeeFPqCEhwmLdNoEKrBokqmziLdYUEGcjlizdlDL"
);

// secret necessário para gerar o token das requisições
define(
	"COBRANCANET_SECRET", 
	"YcUtdFFjXtWwJTNbcErxaODDFzNAuRySuSMYZRIwMfsWzGycLqamFdqKcELYXJqRdEqCXAyjfqGfyFHKwhxBLnMosZMPiDiMIZOfaNPFFWlEbsPYbMamBmbtMnKursIASXgslwzqSkuueKSFYssagUUsIfoBZxCrUilGekyyWssAELGdFzDlTZfdETeaRhWnPHtusrGFDSAqyWTEUYqpxWSCqygJfDxwLrrEjkTWYjNXFhbbGRQEokHfio"
);

// token de segurança que é enviado pelo CobrancaNet na hora de informar
// para a aplicação do usuário de que existem débitos para serem baixados (isto é, pagos)
define(
	"COBRANCANET_TOKEN_RETORNO", 
	"wJTNbcErxaODDFzNAuRySuSMYZRIw"
);