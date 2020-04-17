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

     <link rel="shortcut icon" href="http://www.mylogbox.com/pallas41/img/logo-03.png" />

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

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Usuários</title>
</head>

<script>
$(document).ready(function() {

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

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
     $dad = array();
     include_once "dados.php";
     include_once "funcoes.php";
     $_SESSION['wrknumvol'] = 1;
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6,"Entrada na página de consulta de usuáruos do sistema Pallas.41 - MyLogBox do Brasil");  
          }
     }
?>

<body id="box00">
     <h1 class="cab-0">MyLogBox - Manutenção Usuários  - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <div class="row qua-2 ">
                    <div class="col-md-11 text-left">
                         <span>Consulta de Usuários</span>
                    </div>
                    <div class="col-md-1">
                         <form name="frmTelNov" action="man-usuario.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Mostra campos para criar novo usuário no sistema"><i
                                             class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                              </div>
                         </form>
                    </div>
               </div>
               <div class="row">
                    <div class="col-md-12">
                         <br />
                         <div class="tab-1 table-responsive">
                              <table id="tab-0" class="table table-sm table-striped">
                                   <thead>
                                        <tr>
                                             <th>Alterar</th>
                                             <th>Excluir</th>
                                             <th>Código</th>
                                             <th>Nome</th>
                                             <th>Status</th>
                                             <th>E-Mail</th>
                                             <th>Tipo</th>
                                             <th>Validade</th>
                                             <th>Acessos</th>
                                             <th>Inclusão</th>
                                             <th>Alteração</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php $ret = carrega_usu();  ?>
                                   </tbody>
                              </table>
                              <hr />
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_usu() {
     include_once "dados.php";
     $com = "Select * from tb_usuario order by usunome, idsenha";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
         $txt =  '<tr>';
         $txt .= '<td class="bot-3 text-center"><a href="man-usuario.php?ope=2&cod=' . $lin['idsenha'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a href="man-usuario.php?ope=3&cod=' . $lin['idsenha'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
         $txt .= '<td class="text-center">' . $lin['idsenha'] . '</td>';
         $txt .= "<td>" . $lin['usunome'] . "</td>";
         if ($lin['usustatus'] == 0) {$txt .= "<td>" . "Normal" . "</td>";}
         if ($lin['usustatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
         if ($lin['usustatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
         if ($lin['usustatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
         $txt .= "<td>" . $lin['usuemail'] . "</td>";
         if ($lin['usutipo'] == 0) {$txt .= "<td>" . "Visitante" . "</td>";}
         if ($lin['usutipo'] == 1) {$txt .= "<td>" . "Cliente" . "</td>";}
         if ($lin['usutipo'] == 2) {$txt .= "<td>" . "Colaborador" . "</td>";}
         if ($lin['usutipo'] == 3) {$txt .= "<td>" . "Chefia" . "</td>";}
         if ($lin['usutipo'] == 4) {$txt .= "<td>" . "Supervisor" . "</td>";}
         if ($lin['usutipo'] == 5) {$txt .= "<td>" . "Gerência" . "</td>";}
         if ($lin['usutipo'] == 6) {$txt .= "<td>" . "Diretoria" . "</td>";}
         if ($lin['usutipo'] == 7) {$txt .= "<td>" . "Presidência" . "</td>";}
         if ($lin['usuvalidade'] == null) {
               $txt .= "<td>" . '' . "</td>";
          }else{
               $txt .= "<td>" . date('d/m/Y',strtotime($lin['usuvalidade'])) . "</td>";
          }
         $txt .= '<td class="text-center">' . $lin['usuacessos'] . '</td>';
         if ($lin['datinc'] == null) {
               $txt .= "<td>" . '' . "</td>";
          }else{
               $txt .= "<td>" . date('d/m/Y H:m:s',strtotime($lin['datinc'])) . "</td>";
         }
         if ($lin['datalt'] == null) {
             $txt .= "<td>" . '' . "</td>";
         }else{
             $txt .= "<td>" . date('d/m/Y H:m:s',strtotime($lin['datalt'])) . "</td>";
         }
         $txt .= "</tr>";
         echo $txt;
     }
}

?>

</html>