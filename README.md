# cobrancanet
Conjunto de classes criado para facilitar a integração do sistema CobrancaNet com os sistemas de terceiros.

```
use CobrancaNet\CobrancaNet;
$user_id = ""; // acessar www.cobranca.net.br para obter um user_id
$secret = ""; // acessar www.cobranca.net.br para obter um secret

$CobrancaNet = new CobrancaNet( $user_id, $secret ); 
$CobrancaNet->set('codigoConvenio', '0123456789');
```
