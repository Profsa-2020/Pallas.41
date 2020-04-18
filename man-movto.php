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

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Movimento</title>
</head>

<script>
$(function() {
     $("#cpf").mask("000.000.000-00");
     $("#pes").mask("999.999,9999", { reverse: true });
     $("#dat").datepicker($.datepicker.regional["pt-BR"]);
});

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
     $per = "";
     $end = "";
     $bot = "Salvar";
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
               $ret = gravar_log(6,"Entrada na página de manutenção de movimento do sistema Pallas.41 - MyLogBox do Brasil");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0  : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0  : $_REQUEST['sta']);
     $dat = (isset($_REQUEST['dat']) == false ? ''  : $_REQUEST['dat']);
     $hor = (isset($_REQUEST['hor']) == false ? ''  : $_REQUEST['hor']);
     $tip = (isset($_REQUEST['tip']) == false ? '' : $_REQUEST['tip']);
     $qtd = (isset($_REQUEST['qtd']) == false ? '' : $_REQUEST['qtd']);
     $cli = (isset($_REQUEST['cli']) == false ? 0 : $_REQUEST['cli']);
     $tra = (isset($_REQUEST['tra']) == false ? 0 : $_REQUEST['tra']);
     $pro = (isset($_REQUEST['pro']) == false ? 0 : $_REQUEST['pro']);
     $pre = (isset($_REQUEST['pre']) == false ? '' : $_REQUEST['pre']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de movimento informado em tela ?\')" ';
     }  

     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
               $ret = ler_movto($cha, $dat, $sta, $hor, $tip, $qtd, $cli, $tra, $pro, $pre, $obs); 
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $_SESSION['wrkcodreg'] = ultimo_cod();               
               $ret = consiste_mov();
               if ($ret == 0) {
                    $ret = incluir_mov();
                    $ret = gravar_log(11,"Inclusão de novo movimento: " . $des);
                    $sta = 0; $dat = ''; $hor = ''; $tip = ''; $qtd = ''; $cli = 0; $tra = 0; $pro = 0; $pre = ''; $obs = ''; $cod = ultimo_cod();
               }
          }

     }

     ?>


     <?php
function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = quantidade_reg('Select idproduto, prodescricao from tb_produto order by idproduto desc Limit 1', $men, $reg);     
     if ($nro == 1) {
          $cod = $reg['idproduto'] + 1;
     }
     return $cod;
}

function carrega_tra($loc) {
     $sta = 0;
     include_once "dados.php";    
     if ($loc == 0) {
          echo '<option value="0" selected="selected">Selecione transação desejada ...</option>';
     }
     $com = "Select idgrupo, grudescricao from tb_grupo where grustatus = 0 and grutiporeg = 3 and gruempresa = " . $_SESSION['wrkcodemp'] . " order by grudescricao";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idgrupo'] != $loc) {
               echo  '<option value ="' . $lin['idgrupo'] . '">' . $lin['grudescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $lin['idgrupo'] . '" selected="selected">' . $lin['grudescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_cli($cli) {
     $sta = 0;
     include_once "dados.php";    
     if ($cli == 0) {
          echo '<option value="0" selected="selected">Selecione cliente desejado ...</option>';
     }
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
     if ($pro == 0) {
          echo '<option value="0" selected="selected">Selecione produto desejado ...</option>';
     }
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

function ler_movto($cha, &$dat, &$sta, &$hor, &$tip, &$qtd, &$cli, &$tra, &$pro, &$pre, &$obs) {
     include_once "dados.php";
     $nro = quantidade_reg("Select * from tb_movto where idmovto = " . $cha, $men, $lin);     
     if ($nro == 0 || $lin == false) {
          echo '<script>alert("Número do movimento informado não cadastrado");</script>';
          $nro = 1;
     } else {
          $cha = $lin['idmovto'];
          $dat = date('d/m/Y', strtotime($lin['movdata']));
          $hor = date('H:m', strtotime($lin['movdata']));
          $sta = $lin['movstatus'];
          $tip = $lin['movtipo'];
          $cli = $lin['movcliente'];
          $tra = $lin['movtransacao'];
          $pro = $lin['movproduto'];
          $cli = $lin['movcliente'];
          $obs = $lin['movobservacao'];
          $pre = number_format($lin['movpreco'], 2, ",", ".");
          $qtd = number_format($lin['movquantidade'], 4, ",", ".");
     }
     return $cha;
 }

?>

     </html>
