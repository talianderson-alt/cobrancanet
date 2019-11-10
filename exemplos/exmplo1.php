
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title> </title>
   <script src="./js/download.js"></script>
   <script>
   	(function(downloadArquivo) {
    "use strict";

	    document.addEventListener("DOMContentLoaded", function() {
	        downloadArquivo("../index.php", function(progresso, total, perc) {
	            document.querySelector("progress").value = perc;
	        }).then(function(arrayBuffer) {
	            //cria  um Blob  a partir do arrayBuffer
	            var blob = new Blob([arrayBuffer], {
	                type: "application/pdf"
	            });
	            var fileUrl = URL.createObjectURL( blob ); 
	            window.open( fileUrl ); 
	        }).catch(function(erro) {
	            console.log(erro);
	        });
	    }, false);

	})(downloadArquivo);
   </script>
</head>
<body>
<div>
Exemplo do post: <a href="/2015/02/06/download-de-arquivo-com-ajax.html">
           http://victorvhpg.github.io/2015/02/06/download-de-arquivo-com-ajax.html</a>
</div>

<div id="url">Progresso do download: <progress style="width:500px" min="0" max="100" value="0"></progress></div>
<a href="">Link</a>
</body>
</html>