<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description" content="Profsa Informática - MyLogBox - Controle de estoques para clientes" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="shortcut icon" href="https://www.mylogbox.com/pallas41/img/logo-03.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="css/pallas41p.css" rel="stylesheet" type="text/css" media="print" />
     <title>MyLogBox - Controle de Estoques - Etiquetas</title>
</head>

<script>
$(document).ready(function() {
     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>

<?php
     $ret = 00;
     $txt = "";
     include_once "dados.php";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6,"Entrada na página de impressão de etiquetas de produtos do sistema Pallas.41 - MyLogBox do Brasil");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }

     $nro = quantidade_reg("Select P.*, L.grudescricao, C.clinome from ((tb_produto P left join tb_cliente C on P.procliente = C.idcliente) left join tb_grupo L on P.prolocal = L.idgrupo) where idproduto = " . $_SESSION['wrkcodreg'], $men, $lin);     
     if ($nro == 0 || $lin == false) {
          echo '<script>alert("Código do produto solicitado não está cadastrado");</script>';
          $nro = 1;
     } else {
          $txt .= '<span><strong>' . 'Código do Cliente: ' . $lin['procliente'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Nome do Cliente: ' . $lin['clinome'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Número do Suite: ' . $lin['prosuite'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Local do Produto: ' . $lin['grudescricao'] . '</strong></span><br />';
          $txt .= '<hr />';
          $txt .= '<span>' . 'Código do Produto: ' . $lin['idproduto'] . '</span><br />';
          $txt .= '<span>' . 'Descrição do Produto: ' . $lin['prodescricao'] . '</span><br />';
          $txt .= '<span>' . 'Unidade de Medida: ' . $lin['prounidade'] . '</span><br />';
          $txt .= '<span>' . 'Quantidade do Produto: ' . number_format($lin['proquantidade'], 0, ",", ".") . '</span><br />';
          $txt .= '<span>' . 'Peso do Produto: ' . number_format($lin['propeso'], 4, ",", ".") . '</span><br />';
     }

?>

<body id="box00">
     <h1 class="cab-0">MyLogBox - Etiqueta de Produtos - Controle de Estoques - Profsa Informática</h1>
     <br /> 
     <div class="row text-center">
          <div class="col-md-4"></div>
          <div class="qua-5 col-md-4">
               <?php 
                    echo $txt;  
                    echo '<script> window.print(); </script>';
               ?>
          </div>
          <div class="col-md-4"></div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php

?>

</html>