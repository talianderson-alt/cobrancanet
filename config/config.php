<?php

define("COBRANCANET_PRDC", array(
	'token' => 'http://boleto.net/auth/token',
	'registro' => 'http://boleto.net/auth/validar',
	'consulta' => 'http://boleto.net/auth/consultar',
	'retorno' => 'http://boleto.net/auth/retorno'
));

define("COBRANCANET_HMLG", array(
	'token' => 'http://boleto.net/auth/token',
	'registro' => 'http://boleto.net/auth/validar',
	'consulta' => 'http://boleto.net/auth/consultar',
	'retorno' => 'http://boleto.net/auth/retorno'
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