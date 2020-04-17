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

     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Login</title>
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
     include_once "funcoes.php";
     $_SESSION['wrknumvol'] = 0;
     $_SESSION['wrknompro'] = __FILE__; 
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif (isset($_SESSION['wrktipban']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "login.php"</script>');   
     }  
     $tab = array();
     $ret = carrega_dash($tab);

?>

<body id="box00">
     <h1 class="cab-0">Menu Inicial MyLogBox - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <br />
     <div class="container-fluid">
          <div class="row text-center">
               <div class="col-md-12">
                    <h2><span><strong><i class="fa fa-tachometer fa-1g" aria-hidden="true"></i>
                                   DashBoard</strong></span></h2>
               </div>
          </div>
     </div>

     <br />
     <div class="row">
          <div class="col-md-1"></div>
          <div class="qua-4 col-md-2 text-center">
               <i class="fa fa-filter fa-1g" aria-hidden="true"></i><br /><span> Grupos </span><br />
               <span><?php echo number_format($tab['gru'], 0, ",", "."); ?></span>
          </div>
          <div class="qua-4 col-md-2 text-center">
               <i class="fa fa-archive fa-1g" aria-hidden="true"></i><br /><span> Locais </span><br />
               <span><?php echo number_format($tab['loc'], 0, ",", "."); ?></span>
          </div>
          <div class="qua-4 col-md-2 text-center">
               <i class="fa fa-id-badge fa-1g" aria-hidden="true"></i><br /><span> Usuários </span><br />
               <span><?php echo number_format($tab['usu'], 0, ",", "."); ?></span>
          </div>
          <div class="qua-4 col-md-2 text-center">
               <i class="fa fa-users fa-1g" aria-hidden="true"></i><br /><span> Clientes </span><br />
               <span><?php echo number_format($tab['cli'], 0, ",", "."); ?></span>
          </div>
          <div class="qua-4 col-md-2 text-center">
               <i class="fa fa-barcode fa-1g" aria-hidden="true"></i><br /><span> Produtos </span><br />
               <span><?php echo number_format($tab['pro'], 0, ",", "."); ?></span>
          </div>
          <div class="col-md-1"></div>
     </div>
     <br />
     <hr /><br />

     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_dash(&$tab) {
     $sta = 0;
     $tab['usu'] = 0;
     $tab['cli'] = 0;
     $tab['pro'] = 0;
     $tab['gru'] = 0;
     $tab['loc'] = 0;
     include_once "dados.php";
     $com = "Select count(*) as qtdlinhas from tb_usuario";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $tab['usu'] = $lin['qtdlinhas'];
     }
     $com = "Select count(*) as qtdlinhas from tb_cliente where cliempresa = " . $_SESSION['wrkcodemp'];
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $tab['cli'] = $lin['qtdlinhas'];
     }
     $com = "Select count(*) as qtdlinhas from tb_produto where proempresa = " . $_SESSION['wrkcodemp'];
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $tab['pro'] = $lin['qtdlinhas'];
     }
     $com = "Select count(*) as qtdlinhas from tb_grupo where grutiporeg = 1 and gruempresa = " . $_SESSION['wrkcodemp'];
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $tab['gru'] = $lin['qtdlinhas'];
     }
     $com = "Select count(*) as qtdlinhas from tb_grupo where grutiporeg = 2 and gruempresa = " . $_SESSION['wrkcodemp'];
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $tab['loc'] = $lin['qtdlinhas'];
     }

     return $sta;
 }

?>

</html>