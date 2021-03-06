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

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Produtos</title>
</head>

<script>
$(document).ready(function() {
     $(function() {
          $("#dti").mask("99/99/9999");
          $("#dtf").mask("99/99/9999");
          $("#dti").datepicker($.datepicker.regional["pt-BR"]);
          $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
     });

     $('#cli').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#dti').change(function() {
          $('#tab-0 tbody').empty();
     });
     
     $('#dtf').change(function() {
          $('#tab-0 tbody').empty();
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
               [3, 'asc'],
               [7, 'asc'],
               [5, 'asc'],
               [2, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de movimento ...",
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
     $dti = date('d/m/Y', strtotime('-30 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     $cli = (isset($_REQUEST['cli']) == false ? 0 : $_REQUEST['cli']);
     $pro = (isset($_REQUEST['pro']) == false ? 0 : $_REQUEST['pro']);

?>

<body id="box00">
     <h1 class="cab-0">MyLogBox - Consulta de Produtos  - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container-fluid">
          <div class="qua-0">
               <div class="row qua-2 ">
                    <div class="col-md-11 text-left">
                         <span>Consulta de Movimento</span>
                    </div>
                    <div class="col-md-1">
                         <form name="frmTelNov" action="man-movto.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Mostra campos para criar novo movimento de estoque no sistema"><i
                                             class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                              </div>
                         </form>
                    </div>
               </div>

               <form name="frmTelMan" action="" method="POST">
                    <div class="row">
                         <div class="col-md-1"></div>
                         <div class="col-md-5">
                              <label>Nome do Cliente</label>
                              <select id="cli" name="cli" class="form-control">
                                   <?php $ret = carrega_cli($cli); ?>
                              </select>
                         </div>
                         <div class="col-md-1"></div>
                         <div class="col-md-2">
                              <label>Data Inicial</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="dti" name="dti"
                                   value="<?php echo $dti; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Data Final</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="dtf" name="dtf"
                                   value="<?php echo $dtf; ?>" required />
                         </div>
                         <div class="col-md-1 text-center">
                              <br />
                              <button type="submit" id="con" name="consulta" class="bot-2"
                                   title="Carrega movimento conforme periodo solicitado pelo usuário."><i
                                        class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                         </div>
                    </div>
                    <br />
               </form>
               <br />
               <div class="row">
                    <div class="col-md-12">
                         <br />
                         <div class="tab-1 table-responsive">
                              <table id="tab-0" class="table table-sm table-striped">
                                   <thead>
                                        <tr>
                                             <th>Alterar</th>
                                             <th>Excluir</th>
                                             <th>Número</th>
                                             <th>Nome do Cliente</th>
                                             <th>Suite</th>
                                             <th>Descrição do Produto</th>
                                             <th>Status</th>
                                             <th>Data e Hora</th>
                                             <th>Transação</th>
                                             <th>Tipo</th>
                                             <th>Quantidade</th>
                                             <th>Peso</th>
                                             <th>Preço</th>
                                             <th>Valor</th>
                                             <th>Observação do Movimento</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php $ret = carrega_mov($cli, $dti, $dtf);  ?>
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
function carrega_mov($cli, $dti, $dtf) {
     include_once "dados.php";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     $com  = "Select M.*, P.prodescricao, C.clinome, T.grudescricao as tradescricao from (((tb_movto M left join tb_produto P on M.movproduto = P.idproduto) left join tb_cliente C on M.movcliente = C.idcliente) left join tb_grupo T on M.movtransacao = T.idgrupo) where movempresa = " . $_SESSION['wrkcodemp'];
     if ($cli != 0) { $com .= " and movcliente = " . $cli; }
     
     $com .= " and movdata between '" . $dti . "' and '" . $dtf . "' ";

     $com .= " order by movcliente, movdata, movproduto, idmovto";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
         $txt =  '<tr>';
         $txt .= '<td class="bot-3 text-center"><a href="man-movto.php?ope=2&cod=' . $lin['idmovto'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a href="man-movto.php?ope=3&cod=' . $lin['idmovto'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
         $txt .= '<td class="text-center">' . $lin['idmovto'] . '</td>';
         $txt .= "<td>" . $lin['clinome'] . "</td>";
         $txt .= '<td class="text-center">' . $lin['movsuite'] . '</td>';
         $txt .= "<td>" . $lin['prodescricao'] . "</td>";
         if ($lin['movstatus'] == 0) {$txt .= "<td>" . "Normal" . "</td>";}
         if ($lin['movstatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
         if ($lin['movstatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
         if ($lin['movstatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
         $txt .= "<td>" . date('d/m/Y H:i', strtotime($lin['movdata'])) . "</td>";
         $txt .= "<td>" . $lin['tradescricao'] . "</td>";
         if ($lin['movtipo'] == 0) {$txt .= "<td>" . "Inicial(+)" . "</td>";}
         if ($lin['movtipo'] == 1) {$txt .= "<td>" . "Entrada(+)" . "</td>";}
         if ($lin['movtipo'] == 2) {$txt .= "<td>" . "Saída(-)" . "</td>";}
         if ($lin['movtipo'] == 3) {$txt .= "<td>" . "Nulo(*)" . "</td>";}
         $txt .= '<td class="text-right">' . number_format($lin['movquantidade'], 0, ",", ".") . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['movpeso'], 4, ",", ".") . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['movpreco'], 2, ",", ".") . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['movvalor'], 2, ",", ".") . "</td>";
         $txt .= "<td>" . $lin['movobservacao'] . "</td>";
         $txt .= "</tr>";
         echo $txt;
     }
}

function carrega_cli($cli) {
     $sta = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione cliente desejado ...</option>';
     $com = "Select idcliente, clinome from tb_cliente where clistatus = 0  and cliempresa = " . $_SESSION['wrkcodemp'] . " order by clinome";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idcliente'] != $cli) {
               echo  '<option value ="' . $lin['idcliente'] . '">' . $lin['clinome'] . '</option>'; 
          }else{
               echo  '<option value ="' . $lin['idcliente'] . '" selected="selected">' . $lin['clinome'] . '</option>';
          }
     }
     return $sta;
}

function carrega_pro($pro) {
     $sta = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione produto desejado ...</option>';
     $com = "Select idproduto, prodescricao from tb_produto where prostatus = 0  and proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idproduto'] != $pro) {
               echo  '<option value ="' . $lin['idproduto'] . '">' . $lin['prodescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $lin['idproduto'] . '" selected="selected">' . $lin['prodescricao'] . '</option>';
          }
     }
     return $sta;
}

?>

</html>
