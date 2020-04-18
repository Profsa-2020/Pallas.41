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
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Produtos</title>
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

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [4, 'asc'],
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
                                             <th>Suite</th>
                                             <th>Nome do Cliente</th>
                                             <th>Descrição do Produto</th>
                                             <th>Status</th>
                                             <th>Data e Hora</th>
                                             <th>Transação</th>
                                             <th>Tipo</th>
                                             <th>Quantidade</th>
                                             <th>Preço</th>
                                             <th>Valor</th>
                                             <th>Observação do Movimento</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php $ret = carrega_mov();  ?>
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
function carrega_mov() {
     include_once "dados.php";
     $com = "Select P.*, C.clinome, L.grudescricao as locdescricao, G.grudescricao as grudescricao from (((tb_produto P left join tb_cliente C on P.procliente = C.idcliente) left join tb_grupo L on P.prolocal = L.idgrupo) left join tb_grupo G on P.progrupo = G.idgrupo) where proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao, idproduto";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
         $txt =  '<tr>';
         $txt .= '<td class="bot-3 text-center"><a href="man-movto.php?ope=2&cod=' . $lin['idproduto'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a href="man-movto.php?ope=3&cod=' . $lin['idproduto'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
         $txt .= "<td>" . $lin['clinome'] . "</td>";
         $txt .= '<td class="text-center">' . $lin['idproduto'] . '</td>';
         if ($lin['prostatus'] == 0) {$txt .= "<td>" . "Normal" . "</td>";}
         if ($lin['prostatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
         if ($lin['prostatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
         if ($lin['prostatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
         $txt .= '<td class="text-center">' . $lin['prosuite'] . "</td>";
         $txt .= "<td>" . $lin['prodescricao'] . "</td>";
         $txt .= "<td>" . $lin['prounidade'] . "</td>";         
         $txt .= "<td>" . $lin['grudescricao'] . "</td>";
         $txt .= "<td>" . $lin['locdescricao'] . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['propeso'], 4, ",", ".") . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['propreco'], 2, ",", ".") . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['proestoque'], 0, ",", ".") . "</td>";
         $txt .= "<td>" . $lin['proobservacao'] . "</td>";
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
