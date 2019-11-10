<html>
<head>
	<style>

		table{
			margin: 20px;
			margin-top: 40px;
		}
		table td{
			border-bottom: 1px solid #000;
			border-right: 1px solid #000;
		}

		table td{
			min-height: 90px;
			border-right: thin solid #000;
			border-bottom: thin solid #000;
		}

		td .label{
			width:auto;
			font-style: italic;
			font-size: 10px;
			margin-top:-4px;
		} 

		td.dottedrightborder{
			border-right: thin dotted #000;
			border-bottom: thin solid #000;
		}

		td.noborderbottom{
			border-bottom: none;
		}

		td.noborderright{
			border-right: none;
		}

		td p.valor{
			text-align: right;
			width: 100%;
			font-size: 14px;  
			margin-top:-5px;
			font-style: bold;
			border:1px solid red;
			padding: 5px 0;
		}

		td .textleft{
			text-align: left;
		}
	</style>
</head>
<body>

	<table>
		<tbody>
			<tr>
				<td>
				</td>
				<td>
				</td>
				<td colspan="4">
					<p class="valor">
						{linhaDigitavel}
					</p>
				</td>
			</tr>
			<tr>
				
				<td colspan="5"><div class="label">Lodal do pagamento</div>
					<p class="valor textleft">Pagavel em qualquer banco até o vencimento</p>
				</td>
				<td width="150"><div class="label">Vencimento</div>
					<p class="valor">
						{dataVencimentoTitulo}
					</p>
				</td> 
			</tr>
			<tr>
				<td colspan="5"><div class="label">Beneficiário</div>
					<p class="valor textleft">
						{nomeCedente}
					</p>
				</td>
				<td><div class="label">Agência/Cód. Cedente</div>
					<p class="valor">
						{agencia}/{cedente}
					</p>
				</td> 
			</tr>
			<tr>
				<td width="100"><div class="label">Data documento</div>
					<p class="valor">
						{data_debito}
					</p>
				</td>
				<td width="100"><div class="label">Número documento</div>
					<p class="valor">
						{numeroDocumento}
					</p>
				</td>
				<td width="100"><div class="label">Espécie</div>
					<p class="valor">
						{especie}
					</p>
				</td>
				<td width="100"><div class="label">Aceite</div>
					<p class="valor">
						{aceite}
					</p>
				</td>
				<td width="100"><div class="label">Data processamento</div>
					<p class="valor">
						{dataProcessamento}
					</p>
				</td>
				<td width="100"><div class="label">Nosso Número</div>
					<p class='valor'>
						{nossoNumero}
					</p>
				</td>
			</tr>
			<tr>
				<td><div class="label">Uso do banco</div>
					<p class="valor">&nbsp;</p>
				</td>
				<td><div class="label">Carteira</div>
					<p class="valor">
						{carteira}
					</p>
				</td>
				<td><div class="label">Espécie moeda</div>
					<p class="valor">
						{especie}
					</p>
				</td>
				<td><div class="label">Quantidade</div>
					<p class="valor">&nbsp;</p>
				</td>
				<td><div class="label">Valor</div>
					<p class="valor">
						{valorOriginalTitulo}
					</p>
				</td>
				<td> <div class="label">Valor documento</div>
					<p class="valor">
						{valorOriginalTitulo}
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="5" rowspan="5" width="580"  valign="top">
					<div class="label">Instruções</div>
					<p class="valor textleft">{mensagem1}</p><br/>
					<p class="valor textleft">{mensagem2}</p><br/>
					<p class="valor textleft">{mensagem3}</p><br/>
					<p class="valor textleft">{mensagem4}</p><br/> 
				</td>
				<td><div class="label">Desconto</div>
					<p class="valor">
						R$ {desconto}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Outras deduções</div>
					<p class="valor">
						R$ {deducoes}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Mora/multa</div>
					<p class="valor">
						R$ {mora}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Outros acrescimos</div>
					<p class="valor">
						R$ {correcao}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Valor cobrado</div>
					<p class="valor">
						R$ {valor}
					</p>
				</td> 
			</tr> 
			<tr>
				<td colspan="5" valign="top">
					<div class="label">Pagador</div>
					<p class="valor textleft">
						{nomePagador}<br/>
						{textoEnderecoPagador}
						{siglaUfPagador}
						{nomeMunicipioPagador}<br/>
						{numeroCepPagador}
					</p>

				</td>
				<td valign="top">
					<div class="label">CPF/CNPJ</div>
					<p class="valor textleft">
						{numeroInscricaoPagador}
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="6" class="noborderright noborderbottom">
					<hr style="border-style: dotted" />
				</td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td>
				</td>
				<td>
				</td>
				<td colspan="4">
					<p class="valor">
						{linhaDigitavel}
					</p>
				</td>
			</tr>
			<tr>
				
				<td colspan="5"><div class="label">Lodal do pagamento</div>
					<p class="valor textleft">Pagavel em qualquer banco até o vencimento</p>
				</td>
				<td width="150"><div class="label">Vencimento</div>
					<p class="valor">
						{dataVencimentoTitulo}
					</p>
				</td> 
			</tr>
			<tr>
				<td colspan="5"><div class="label">Beneficiário</div>
					<p class="valor textleft">
						{nomeCedente}
					</p>
				</td>
				<td><div class="label">Agência/Cód. Cedente</div>
					<p class="valor">
						{agencia}/{cedente}
					</p>
				</td> 
			</tr>
			<tr>
				<td width="100"><div class="label">Data documento</div>
					<p class="valor">
						{data_debito}
					</p>
				</td>
				<td width="100"><div class="label">Número documento</div>
					<p class="valor">
						{numeroDocumento}
					</p>
				</td>
				<td width="100"><div class="label">Espécie</div>
					<p class="valor">
						{especie}
					</p>
				</td>
				<td width="100"><div class="label">Aceite</div>
					<p class="valor">
						{aceite}
					</p>
				</td>
				<td width="100"><div class="label">Data processamento</div>
					<p class="valor">
						{dataProcessamento}
					</p>
				</td>
				<td width="100"><div class="label">Nosso Número</div>
					<p class='valor'>
						{nossoNumero}
					</p>
				</td>
			</tr>
			<tr>
				<td><div class="label">Uso do banco</div>
					<p class="valor">&nbsp;</p>
				</td>
				<td><div class="label">Carteira</div>
					<p class="valor">
						{carteira}
					</p>
				</td>
				<td><div class="label">Espécie moeda</div>
					<p class="valor">
						{especie}
					</p>
				</td>
				<td><div class="label">Quantidade</div>
					<p class="valor">&nbsp;</p>
				</td>
				<td><div class="label">Valor</div>
					<p class="valor">
						R$ {valorOriginalTitulo}
					</p>
				</td>
				<td> <div class="label">Valor documento</div>
					<p class="valor">
						R$ {valorOriginalTitulo}
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="5" rowspan="5" width="580"  valign="top">
					<div class="label">Instruções</div>
					<p class="valor textleft">{mensagem1}</p><br/>
					<p class="valor textleft">{mensagem2}</p><br/>
					<p class="valor textleft">{mensagem3}</p><br/>
					<p class="valor textleft">{mensagem4}</p><br/> 
				</td>
				<td><div class="label">Desconto</div>
					<p class="valor">
						R$ {desconto}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Outras deduções</div>
					<p class="valor">
						R$ {deducoes}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Mora/multa</div>
					<p class="valor">
						R$ {mora}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Outros acrescimos</div>
					<p class="valor">
						R$ {correcao}
					</p>
				</td> 
			</tr>
			<tr> 
				<td><div class="label">Valor cobrado</div>
					<p class="valor">
						R$ {valor}
					</p>
				</td> 
			</tr> 
			<tr>
				<td colspan="5" valign="top">
					<div class="label">Pagador</div>
					<p class="valor textleft">
						{nomePagador}<br/>
						{textoEnderecoPagador}
						{siglaUfPagador}
						{nomeMunicipioPagador}<br/>
						{numeroCepPagador}
					</p>

				</td>
				<td valign="top">
					<div class="label">CPF/CNPJ</div>
					<p class="valor textleft">
						{numeroInscricaoPagador}
					</p>
				</td>
			</tr>
			<tr>
				<td colspan="6" class="noborderright noborderbottom">
					<hr style="border-style: dotted" />
				</td>
			</tr>
			<tr>
				<td colspan="6" class="noborderbottom noborderright">
					<div class="label">Autenticação mecânica</div>
					<barcode label="none"  value="{codigoDeBarras}" type="I25" style="width: 110mm;height: 12mm"></barcode>
				</td>
			</tr>
		</tbody>
			
	 
	</table>
</body>
</html>