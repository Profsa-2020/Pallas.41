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
     $(".item").click(function() {
          var cod = $(this).attr("cod");
          $.getJSON("carrega-ima.php", { cod: cod })
          .done(function(data) {
               if (data.msg != "") {
                    alert(data.msg);
               } else {
                    $('#tit-fot').empty().html(data.txt);
                    $('#fot-pro').modal('show');
               }
          }).fail(function(data){
               console.log(data);
               alert("Erro ocorrido no processamento da imagem do produto");
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
               [4, 'asc'],
               [8, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de produtos ...",
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
                         <span>Consulta de Produtos</span>
                    </div>
                    <div class="col-md-1">
                         <form name="frmTelNov" action="man-produto.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Mostra campos para criar novo produto no sistema"><i
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
                                             <th>Imagens</th>
                                             <th>Etiqueta</th>
                                             <th>Anexos</th>
                                             <th>Nome do Cliente</th>
                                             <th>Número</th>
                                             <th>Status</th>
                                             <th>Suite</th>
                                             <th>Descrição do Produto</th>
                                             <th>Unidade</th>
                                             <th>Código</th>
                                             <th>Grupo</th>
                                             <th>Local</th>
                                             <th>Peso</th>
                                             <th>Preço</th>
                                             <th>Estoque</th>
                                             <th>Observação para o Produto</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php $ret = carrega_pro();  ?>
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

     <!-- Modal grande -->
     <div id="fot-pro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">     <!-- modal-xl modal-lg -->
               <div class="modal-content">
                    <div class="modal-header">
                         <h4 class="modal-title" id="myLargeModalLabel">Imagens anexas do Produto</h4>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="row text-center">
                              <div class="col-md-12">
                                   <div id="tit-fot"></div>
                              </div>
                         </div>
                         <br />                         
                         <div id="lis-fot"></div>
                    </div>
               </div>
          </div>
     </div>
     <!--------------------->


</body>

<?php
function carrega_pro() {
     include_once "dados.php";
     $com = "Select P.*, C.clinome, L.grudescricao as locdescricao, G.grudescricao as grudescricao from (((tb_produto P left join tb_cliente C on P.procliente = C.idcliente) left join tb_grupo L on P.prolocal = L.idgrupo) left join tb_grupo G on P.progrupo = G.idgrupo) where proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao, idproduto";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
         $txt =  '<tr>';
         $txt .= '<td class="bot-3 text-center"><a href="man-produto.php?ope=2&cod=' . $lin['idproduto'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a href="man-produto.php?ope=3&cod=' . $lin['idproduto'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a class="item" href="#" ope=4 cod=' . $lin['idproduto'] . ' title="Abre janela para ver todas as imagens anexadas ao produto informado na linha"><i class="large material-icons">camera_alt</i></a></td>';
         $txt .= '<td class="lit-d bot-3 text-center"><a href="eti-produto.php?ope=5&cod=' . $lin['idproduto'] . '" target="_blank" title="Efetua impressão de etiqueta para o produto na linha"><i class="large material-icons">print</i></a></td>';
         $txt .= '<td class="text-center">' . anexos_qtd($lin['idproduto']) . "</td>";
         $txt .= "<td>" . $lin['clinome'] . "</td>";
         $txt .= '<td class="text-center">' . $lin['idproduto'] . '</td>';
         if ($lin['prostatus'] == 0) {$txt .= "<td>" . "Normal" . "</td>";}
         if ($lin['prostatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
         if ($lin['prostatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
         if ($lin['prostatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
         $txt .= '<td class="text-center">' . $lin['prosuite'] . "</td>";
         $txt .= "<td>" . $lin['prodescricao'] . "</td>";
         $txt .= "<td>" . $lin['prounidade'] . "</td>";         
         $txt .= "<td>" . $lin['procodigo'] . "</td>";
         $txt .= "<td>" . $lin['grudescricao'] . "</td>";
         $txt .= "<td>" . $lin['locdescricao'] . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['propeso'], 4, ",", ".") . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['propreco'], 2, ",", ".") . "</td>";
         $txt .= '<td class="text-right">' . number_format($lin['proestoqueqtd'], 0, ",", ".") . "</td>";
         $txt .= "<td>" . $lin['proobservacao'] . "</td>";
         $txt .= "</tr>";
         echo $txt;
     }
}

function anexos_qtd($cod) {
     $qtd = 0; 
     include_once "dados.php";
     $qtd = quantidade_reg("Select idanexo, anesequencia from tb_produto_a where aneproduto = " . $cod , $men, $lin);     
     return $qtd;
}

?>

</html>
