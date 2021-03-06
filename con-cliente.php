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
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Clientes</title>
</head>

<script>
$(document).ready(function() {
     $(".item").click(function() {
          var cod = $(this).attr("cod");
          $.getJSON("carrega-end.php", { cod: cod })
          .done(function(data) {
               if (data.msg != "") {
                    alert(data.msg);
               } else {
                    $('#dad_end').empty().html(data.txt);
                    $('#lis-end').modal('show');
               }
          }).fail(function(data){
               console.log(data);
               alert("Erro ocorrido no processamento do endereço do cliente");
          });
     });

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

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [5, 'asc'],
               [4, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de clientes ...",
               "sSearch": "Buscar:",
               "infoFiltered": "(Consulta de _MAX_ total de linhas)",
               "oPaginate": {
                    sFirst: "Primeiro",
                    sLast: "Último",
                    sNext: "Próximo",
                    sPrevious: "Anterior"
               }
          }
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
               $ret = gravar_log(6,"Entrada na página de consulta de clientes do sistema Pallas.41 - MyLogBox do Brasil");  
          }
     }
?>

<body id="box00">
     <h1 class="cab-0">MyLogBox - Consulta de Clientes  - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container-fluid">
          <div class="qua-0">
               <div class="row qua-2 ">
                    <div class="col-md-11 text-left">
                         <span>Consulta de Clientes</span>
                    </div>
                    <div class="col-md-1">
                         <form name="frmTelNov" action="man-cliente.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Mostra campos para criar novo cliente no sistema"><i
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
                                             <th>Endereços</th>
                                             <th>Código</th>
                                             <th>Suite</th>
                                             <th>Nome do Cliente</th>
                                             <th>Status</th>
                                             <th>E-Mail</th>
                                             <th>C.p.f.</th>
                                             <th>Telefone</th>
                                             <th>Celular</th>
                                             <th>Endereço</th>
                                             <th>Bairro</th>
                                             <th>Cidade</th>
                                             <th>UF</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php $ret = carrega_cli();  ?>
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

     <!----------------------------------------------------------------------------------->
     <div class="modal fade" id="lis-end" tabindex="-1" role="dialog" aria-labelledby="tel-end" aria-hidden="true"
          data-backdrop="true">
          <div class="modal-dialog modal-lg" role="document"> <!-- modal-sm modal-lg modal-xl -->
               <form id="frmMosEnd" name="frmMosEnd" action="con-cliente.php" method="POST">
                    <div class="modal-content">
                         <div class="modal-header">
                              <h5 class="modal-title" id="tel-end">Lista de Endereços do Cliente</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                   <span aria-hidden="true">&times;</span>
                              </button>
                         </div>
                         <div class="modal-body">
                              <div class="form-row text-center">
                                   <div class="col-md-12 text-center">
                                        <div id="dad_end"></div>
                                   </div>
                              </div>
                              <br />
                         </div>
                         <div class="modal-footer">
                              <button type="button" id="clo" name="close" class="btn btn-outline-danger"
                                   data-dismiss="modal">Fechar</button>
                         </div>
                    </div>
               </form>
          </div>
     </div>
     <!----------------------------------------------------------------------------------->

</body>

<?php
function carrega_cli() {
     include_once "dados.php";
     $com = "Select * from tb_cliente where cliempresa = " . $_SESSION['wrkcodemp'] . " order by clinome, idcliente";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
         $txt =  '<tr>';
         $txt .= '<td class="bot-3 text-center"><a href="man-cliente.php?ope=2&cod=' . $lin['idcliente'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a href="man-cliente.php?ope=3&cod=' . $lin['idcliente'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a class="item" href="#" ope=4 cod=' . $lin['idcliente'] . ' title="Efetua demonstração de endereços do cliente informado na linha"><i class="large material-icons">location_on</i></a></td>';
         $txt .= '<td class="text-center">' . $lin['idcliente'] . '</td>';
         $txt .= '<td class="text-center">' . $lin['clisuite'] . "</td>";
         $txt .= "<td>" . $lin['clinome'] . "</td>";
         if ($lin['clistatus'] == 0) {$txt .= "<td>" . "Normal" . "</td>";}
         if ($lin['clistatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
         if ($lin['clistatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
         if ($lin['clistatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
         $txt .= "<td>" . $lin['cliemail'] . "</td>";
         $txt .= "<td>" . mascara_cpo($lin['clicpf'], '   .   .   -  ') . "</td>";
         $txt .= "<td>" . $lin['clitelefone'] . "</td>";
         $txt .= "<td>" . $lin['clicelular'] . "</td>";
         $txt .= "<td>" . $lin['cliendereco'] . ', ' . $lin['clinumero'] . ' ' . $lin['clicomplemento'] . "</td>";
         $txt .= "<td>" . $lin['clibairro'] . "</td>";
         $txt .= "<td>" . $lin['clicidade'] . "</td>";
         $txt .= "<td>" . $lin['cliestado'] . "</td>";
         $txt .= "</tr>";
         echo $txt;
     }
}

?>

</html>