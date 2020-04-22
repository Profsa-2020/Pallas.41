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

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Parâmetros</title>
</head>

<script>
$(document).ready(function() {
     $(function() {
          $("#dti").mask("99/99/9999");
          $("#dtf").mask("99/99/9999");
          $("#dti").datepicker($.datepicker.regional["pt-BR"]);
          $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
     });

     $('#dti').change(function() {
          $('#tab-0 tbody').empty();
     });
     $('#dtf').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [0, 'desc'],
               [1, 'desc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Log",
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
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6,"Entrada na página de log de acesso de usuários do sistema Pallas.38 - MyLogBox do Brasil");  
          }
     }
     $dti = date('d/m/Y', strtotime('-6 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     if (isset($_REQUEST['deleta']) == true) {
          if ($_SESSION['wrktipusu'] < 6) {
               echo '<script>alert("Somente Administrador tem permissão de excluir Log !");</script>';
          } else {
               $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
               $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
               $sql  = "delete from tb_log where logdatahora between '" . $dti . "' and '" . $dtf . "' ";
               $ret = mysqli_query($conexao,$sql);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na exclusão do log de acesso no periodo solicitado !");</script>';
               }
               $ret = gravar_log(6, 'Exclusão de Log de Acesso de Usuários no periodo de: ' . $dti . ' até ' . $dtf );  
               $dti = date('d/m/Y', strtotime('-6 days'));
               $dtf = date('d/m/Y');     
          }
     }

?>

<body id="box00">
     <h1 class="cab-0">Menu Inicial MyLogBox do Brasil - Gerenciamento de Licitações - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <form name="frmTelMan" action="" method="POST">
                    <div class="row qua-2">
                         <div class="col-md-11 text-left">
                              <span>Log de Acesso de Usuários</span>
                         </div>
                         <div class="col-md-1 text-center">
                              <button type="submit" id="del" name="deleta" class="bot-2" onclick="return confirm('Confirma exclusão de registro de log no período em tela ?')"
                                   title="Processo para deletar todo o Log do periodo informado no sistema."><i
                                        class="fa fa-trash fa-1g" aria-hidden="true"></i></button>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
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
                                   title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                        class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <br />
               </form>

          </div>
     </div>
     <br /><br />
     <div class="row">
          <div class="tab-1 table-responsive">
               <table id="tab-0" class="table table-sm table-striped">
                    <thead>
                         <tr>
                              <th>Data</th>
                              <th>Hora</th>
                              <th>Ope</th>
                              <th>Usuário</th>
                              <th>Tip</th>
                              <th>Página</th>
                              <th>Número</th>
                              <th>Docto</th>
                              <th>IP</th>
                              <th>Cidade/UF</th>
                              <th>Navegador</th>
                              <th>Provedor</th>
                              <th>Histórico do Log</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php $ret = carrega_log($dti, $dtf);  ?>
                    </tbody>
               </table>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php
function carrega_log($dti, $dtf) {
     $nro = 0;
     include_once "dados.php";
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     $com = "Select logdatahora, logoperacao, logusuario, logtipo, logidsenha, lognumero, logdocto, logip, logcidade, logestado, lognavegador, logprovedor, logprograma, logobservacao from tb_log ";
     $com .= " where logdatahora between '" . $dti . "' and '" . $dtf . "' ";
     if ($_SESSION['wrktipusu'] <= 3) {
          $com .= " and logidsenha =  " . $_SESSION['wrkideusu'];
     }
     $com .= " order by logdatahora desc, idlog ";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
         $txt =  '<tr>';
         $txt .= "<td>" . date('d/m/Y',strtotime($lin['logdatahora'])) . "</td>";
         $txt .= "<td>" . date('H:m:s',strtotime($lin['logdatahora'])) . "</td>";
         $txt .= "<td>{$lin['logoperacao']}</td>";
         $txt .= "<td>{$lin['logusuario']}</td>";
         $txt .= "<td>{$lin['logtipo']}</td>";
         $txt .= "<td>{$lin['logprograma']}</td>";
         $txt .= "<td>{$lin['lognumero']}</td>";
         $txt .= "<td>{$lin['logdocto']}</td>";
         $txt .= "<td>{$lin['logip']} </td>";
         $txt .= '<td>' . $lin['logcidade'] . "-" . $lin['logestado'] . '</td>';
         $txt .= "<td>{$lin['lognavegador']}</td>";
         $txt .= "<td>{$lin['logprovedor']}</td>";
         $txt .= "<td>{$lin['logobservacao']}</td>";
         $txt .= "</tr>";
         echo $txt;
     }
     return $nro;
}

?>

</html>
