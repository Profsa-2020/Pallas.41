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
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Clientes</title>
</head>

<script>
$(function() {
     $(".cep").mask("00000-000");
     $(".num").mask("000.000");     
     $("#cpf").mask("000.000.000-00");
     $("#dat").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {
     $('#end').click(function() {
          var nro = document.getElementsByClassName("qua-3").length ;

          var endereco = ''; nro = nro + 1;
          endereco += '<div class="qua-3">';

          endereco += '<div class="row">';
          endereco += '<div class="col-md-8">';
          endereco += '<label>' + nro + ' - Título do Endereço</label>';
          endereco += '<input type="text" class="form-control" maxlength="50" id="tit_1" name="tit[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '<div class="col-md-2"></div>';
          endereco += '<div class="col-md-2">';
          endereco += '<label>C.e.p.</label>';
          endereco += '<input type="text" class="cep form-control" maxlength="9" id="cep_1" name="cep[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '</div>';
          endereco += '<div class="row">';
          endereco += '<div class="col-md-10">';
          endereco += '<label>Endereço</label>';
          endereco += '<input type="text" class="form-control" maxlength="75" id="end_0" name="end[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '<div class="col-md-2">';
          endereco += '<label>Número</label>';
          endereco += '<input type="text" class="num form-control" maxlength="7" id="num_0" name="num[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '</div>';
          endereco += '<div class="row">';
          endereco += '<div class="col-md-10">';
          endereco += '<label>Complemento</label>';
          endereco += '<input type="text" class="form-control" maxlength="50" id="com_0" name="com[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '<div class="col-md-2"></div>';
          endereco += '</div>';
          endereco += '<div class="row">';
          endereco += '<div class="col-md-6">';
          endereco += '<label>Bairro</label>';
          endereco += '<input type="text" class="form-control" maxlength="50" id="bai_0" name="bai[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '<div class="col-md-5">';
          endereco += '<label>Cidade</label>';
          endereco += '<input type="text" class="form-control" maxlength="30" id="cid_0" name="cid[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '<div class="col-md-1">';
          endereco += '<label>Estado</label>';
          endereco += '<input type="text" class="form-control" maxlength="2" id="est_0" name="est[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '</div>';
          endereco += '<div class="row">';
          endereco += '<div class="col-md-4">';
          endereco += '<label>Telefone</label>';
          endereco += '<input type="text" class="form-control" maxlength="15" id="tel_0" name="tel[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '<div class="col-md-4">';
          endereco += '<label>Celular</label>';
          endereco += '<input type="text" class="form-control" maxlength="15" id="cel_0" name="cel[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '<div class="col-md-4">';
          endereco += '<label>E-Mail</label>';
          endereco += '<input type="email" class="form-control" maxlength="75" id="ema_0" name="ema[]"';
          endereco += 'value="" />';
          endereco += '</div>';
          endereco += '</div>';

          endereco += '</div>';

          $("#end_cli").append(endereco);
     });

     $('#ape').blur(function() {
          var nom = $('#nom').val();
          var ape = $('#ape').val();
          $.getJSON("funcoes-cli.php", {
                    tip: 1,
                    nom: nom,
                    ape: ape
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
                    if (data.ape != "") {
                         $('#ape').val(data.ape);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento dos dados de cliente I");
               });
     });

     $('#cpf').blur(function() {
          var cpf = $('#cpf').val();
          $.getJSON("funcoes-cli.php", {
                    tip: 2,
                    cpf: cpf
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento dos dados de cliente II");
               });
     });

     $('.cep').blur(function() {
          var cod = $(this).attr("id");

     });

     $('#cep_0').blur(function() {
          var cep = $('#cep_0').val();
          var cep = cep.replace(/[^0-9]/g, '');
          if (cep != '') {
               var url = '//viacep.com.br/ws/' + cep + '/json/';
               $.getJSON(url, function(data) {
                    if ("error" in data) {
                         return;
                    }
                    if ($('#end_0').val() == "") {
                         $('#end_0').val(data.logradouro.substring(0, 50));
                    }
                    if ($('#cep_0').val() == "" || $('#cep_0').val() == "-") {
                         $('#cep_0').val(data.cep.replace('.', ''));
                    }
                    if ($('#bai_0').val() == "") {
                         $('#bai_0').val(data.bairro.substring(0, 50));
                    }
                    if ($('#cid_0').val() == "") {
                         $('#cid_0').val(data.localidade);
                    }
                    if ($('#est_0').val() == "") {
                         $('#est_0').val(data.uf);
                    }
               });
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
     $ret = 0;
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
               $ret = gravar_log(6,"Entrada na página de manutenção de clientes do sistema Pallas.41 - MyLogBox do Brasil");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0  : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0  : $_REQUEST['sta']);
     $cpf = (isset($_REQUEST['cpf']) == false ? ''  : $_REQUEST['cpf']);
     $reg = (isset($_REQUEST['reg']) == false ? '' : $_REQUEST['reg']);
     $sen = (isset($_REQUEST['sen']) == false ? '' : $_REQUEST['sen']);
     $sui = (isset($_REQUEST['sui']) == false ? rand(1000, 9999) : $_REQUEST['sui']);
     $ape = (isset($_REQUEST['ape']) == false ? '' : str_replace("'", "´", $_REQUEST['ape']));
     $nom = (isset($_REQUEST['nom']) == false ? '' : str_replace("'", "´", $_REQUEST['nom']));
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));
     $dad['tit'][0] = (isset($_REQUEST['tit'][0]) == false ? 'Domicílio do cliente (casa)' : $_REQUEST['tit'][0]);
     $dad['cep'][0] = (isset($_REQUEST['cep'][0]) == false ? '' : $_REQUEST['cep'][0]);
     $dad['end'][0] = (isset($_REQUEST['end'][0]) == false ? '' : $_REQUEST['end'][0]);
     $dad['num'][0] = (isset($_REQUEST['num'][0]) == false ? '' : $_REQUEST['num'][0]);
     $dad['com'][0] = (isset($_REQUEST['com'][0]) == false ? '' : $_REQUEST['com'][0]);
     $dad['bai'][0] = (isset($_REQUEST['bai'][0]) == false ? '' : $_REQUEST['bai'][0]);
     $dad['cid'][0] = (isset($_REQUEST['cid'][0]) == false ? '' : $_REQUEST['cid'][0]);
     $dad['est'][0] = (isset($_REQUEST['est'][0]) == false ? '' : $_REQUEST['est'][0]);
     $dad['tel'][0] = (isset($_REQUEST['tel'][0]) == false ? '' : $_REQUEST['tel'][0]);
     $dad['cel'][0] = (isset($_REQUEST['cel'][0]) == false ? '' : $_REQUEST['cel'][0]);
     $dad['ema'][0] = (isset($_REQUEST['ema'][0]) == false ? '' : $_REQUEST['ema'][0]);

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de cliente informado em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          $end = ler_endereco();
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1; $_SESSION['wrkcodcli'] = $cha;
               $ret = ler_cliente($cha, $nom, $sta, $ape, $cpf, $reg, $sen, $sui, $obs, $dad); 
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $ret = consiste_cli();
               if ($ret == 0) {
                    $ret = incluir_cli();
                    $ret = incluir_end();
                    $ret = gravar_log(11,"Inclusão de novo cliente: " . $nom);
                    $sta = 0; $cpf = ''; $reg = ''; $sen = ''; $sui = ''; $ape = ''; $nom = ''; $obs = '';  $cod = ultimo_cod();
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_cli();
               if ($ret == 0) {
                   $ret = alterar_cli();
                   $ret = incluir_end();
                   $ret = gravar_log(12,"Alteração de cliente existente: " . $nom); $_SESSION['wrkmostel'] = 0;
                   $sta = 0; $cpf = ''; $reg = ''; $sen = ''; $sui = ''; $ape = ''; $nom = ''; $obs = '';  $cod = ultimo_cod();
                   echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
           }
           if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_cli();
               $ret = gravar_log(13,"Exclusão de cliente existente: " . $nom); $_SESSION['wrkmostel'] = 0;
               $sta = 0; $cpf = ''; $reg = ''; $sen = ''; $sui = ''; $ape = ''; $nom = ''; $obs = '';  $cod = ultimo_cod();
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
           }
     }
?>

<body id="box00">
     <h1 class="cab-0">MyLogBox - Manutenção Clientes - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <div class="row qua-2">
                    <div class="col-md-10 text-left">
                         <span>Manutenção de Clientes</span>
                    </div>
                    <div class="col-md-1">
                         <form name="frmTelNov" action="man-produto.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Abre janela com dados para criar novo produto do cliente no sistema"><i
                                             class="fa fa-barcode fa-1g" aria-hidden="true"></i></button>
                              </div>
                         </form>
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

               <form class="tel-1" name="frmTelMan" action="" method="POST">
                    <div class="row">
                         <div class="col-md-2">
                              <label>Código</label>
                              <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                   value="<?php echo $cod; ?>" disabled />
                         </div>
                         <div class="col-md-8"></div>
                         <div class="col-md-2">
                              <label>Status</label>
                              <select name="sta" class="form-control">
                                   <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                        Normal</option>
                                   <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                        Bloqueado</option>
                                   <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                        Suspenso</option>
                                   <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                        Cancelado</option>
                              </select>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-8">
                              <label>Nome do Cliente</label>
                              <input type="text" class="form-control" maxlength="75" id="nom" name="nom"
                                   value="<?php echo $nom; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Número do C.P.F.</label>
                              <input type="text" class="form-control" maxlength="14" id="cpf" name="cpf"
                                   value="<?php echo $cpf; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Número do R.G.</label>
                              <input type="text" class="form-control" maxlength="15" id="reg" name="reg"
                                   value="<?php echo $reg; ?>" />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-2">
                              <label>Tratamento (Apelido)</label>
                              <input type="text" class="form-control" maxlength="50" id="ape" name="ape"
                                   value="<?php echo $ape; ?>" required />
                         </div>
                         <div class="col-md-3"></div>
                         <div class="col-md-2">
                              <label>Suite</label>
                              <input type="text" class="form-control text-center" maxlength="15" id="sui" name="sui"
                                   value="<?php echo $sui; ?>" required />
                         </div>
                         <div class="col-md-3"></div>
                         <div class="col-md-2">
                              <label>Senha</label>
                              <input type="password" class="form-control" maxlength="15" id="sen" name="sen"
                                   value="<?php echo $sen; ?>" required />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-8">
                              <label>Título do Endereço</label>
                              <input type="text" class="form-control" maxlength="50" id="tit_0" name="tit[]"
                                   value="<?php echo $dad['tit'][0]; ?>" required />
                         </div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <label>C.e.p.</label>
                              <input type="text" class="cep form-control" maxlength="9" id="cep_0" name="cep[]"
                                   value="<?php echo $dad['cep'][0]; ?>" required />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-10">
                              <label>Endereço</label>
                              <input type="text" class="form-control" maxlength="75" id="end_0" name="end[]"
                                   value="<?php echo $dad['end'][0]; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Número</label>
                              <input type="text" class="num form-control" maxlength="7" id="num_0" name="num[]"
                                   value="<?php echo $dad['num'][0]; ?>" />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-10">
                              <label>Complemento</label>
                              <input type="text" class="form-control" maxlength="50" id="com_0" name="com[]"
                                   value="<?php echo $dad['com'][0]; ?>" />
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                              <label>Bairro</label>
                              <input type="text" class="form-control" maxlength="50" id="bai_0" name="bai[]"
                                   value="<?php echo $dad['bai'][0]; ?>" />
                         </div>
                         <div class="col-md-5">
                              <label>Cidade</label>
                              <input type="text" class="form-control" maxlength="30" id="cid_0" name="cid[]"
                                   value="<?php echo $dad['cid'][0]; ?>" />
                         </div>
                         <div class="col-md-1">
                              <label>Estado</label>
                              <input type="text" class="form-control" maxlength="2" id="est_0" name="est[]"
                                   value="<?php echo $dad['est'][0]; ?>" required />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-4">
                              <label>Telefone</label>
                              <input type="text" class="form-control" maxlength="15" id="tel_0" name="tel[]"
                                   value="<?php echo $dad['tel'][0]; ?>" />
                         </div>
                         <div class="col-md-4">
                              <label>Celular</label>
                              <input type="text" class="form-control" maxlength="15" id="cel_0" name="cel[]"
                                   value="<?php echo $dad['cel'][0]; ?>" />
                         </div>
                         <div class="col-md-4">
                              <label>E-Mail</label>
                              <input type="email" class="form-control" maxlength="75" id="ema_0" name="ema[]"
                                   value="<?php echo $dad['ema'][0]; ?>" />
                         </div>
                    </div>
                    <div class="form-row">
                         <div class="col-md-12">
                              <label>Observação</label>
                              <textarea class="form-control" rows="3" id="obs" name="obs"><?php echo $obs ?></textarea>
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8 text-center">
                              <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                   class="bot-1"><?php echo $bot; ?></button>
                         </div>
                         <div class="col-md-2 text-center">
                              <button type="button" class="bot-2" id="end" name="endereco"
                                   title="Adiciona novos campos com informações para criar novo endereço para o cliente no sistema"><i
                                        class="fa fa-map-marker fa-3x" aria-hidden="true"></i></button>
                         </div>
                    </div>
                    <br />
                    <div class="container">
                         <div id="end_cli"> <?php echo $end; ?> </div>
                    </div>
                    <br />
                    <div class="form-row">
                         <div class="col-md-12 text-center">
                              <?php
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                   ?>
                         </div>
                    </div>
                    <br />
               </form>
               <div id="box10">
                    <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
               </div>
          </div>
          <br />
</body>

<?php
function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = quantidade_reg('Select idcliente, clinome from tb_cliente order by idcliente desc Limit 1', $men, $reg);     
     if ($nro == 1) {
          $cod = $reg['idcliente'] + 1;
     }
     return $cod;
 }

 function ler_cliente($cha, &$nom, &$sta, &$ape, &$cpf, &$reg, &$sen, &$sui, &$obs, &$dad) {
     include_once "dados.php";
     $nro = quantidade_reg("Select * from tb_cliente where idcliente = " . $cha, $men, $lin);     
     if ($nro == 0 || $lin == false) {
          echo '<script>alert("Código do cliente informado não cadastrado");</script>';
          $nro = 1;
     } else {
          $cha = $lin['idcliente'];
          $nom = $lin['clinome'];
          $sta = $lin['clistatus'];
          $ape = $lin['clifantasia'];
          $cpf = mascara_cpo($lin['clicpf'], '   .   .   -  ');
          $sen = base64_decode($lin['clisenha']);
          $reg = $lin['cliregistro'];
          $sui = $lin['clisuite'];
          $obs = $lin['cliobservacao'];
          $dad['tit'][0] = $lin['clititulo'];
          $dad['end'][0] = $lin['cliendereco'];
          $dad['com'][0] = $lin['clicomplemento'];
          $dad['bai'][0] = $lin['clibairro'];
          $dad['cid'][0] = $lin['clicidade'];
          $dad['est'][0] = $lin['cliestado'];
          $_SESSION['wrkcodsui'] = $lin['clisuite'];
          $dad['num'][0] = mascara_cpo($lin['clinumero'], '   .   ');
          $dad['cep'][0] = mascara_cpo($lin['clicep'], '     -   ');
     }
     return $cha;
 }

 function ler_endereco() {
     $txt = ""; $qtd = 1;
     include_once "dados.php";
     $com = "Select * from tb_cliente_e where endempresa = " . $_SESSION['wrkcodemp'] . " and endcliente = " . $_SESSION['wrkcodreg'] . " order by idendereco";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $txt .= '<div class="qua-3">';
          $txt .= '<div class="row">
               <div class="col-md-8">
                    <label>' . $qtd . ' - Título do Endereço</label>
                    <input type="text" class="form-control" maxlength="50" id="tit_' . $qtd . '" name="tit[]"
                         value="' . $lin['endtitulo'] . '" required />
               </div>
               <div class="col-md-2"></div>
               <div class="col-md-2">
                    <label>C.e.p.</label>
                    <input type="text" class="cep form-control" maxlength="9" id="cep_' . $qtd . '" name="cep[]"
                         value="' . $lin['endcep'] . '" required />
               </div>
          </div>
          <div class="row">
               <div class="col-md-10">
                    <label>Endereço</label>
                    <input type="text" class="form-control" maxlength="75" id="end_' . $qtd . '" name="end[]"
                         value="' . $lin['endendereco'] . '" required />
               </div>
               <div class="col-md-2">
                    <label>Número</label>
                    <input type="text" class="num form-control" maxlength="7" id="num_' . $qtd . '" name="num[]"
                         value="' . $lin['endnumero'] . '" />
               </div>
          </div>
          <div class="row">
               <div class="col-md-10">
                    <label>Complemento</label>
                    <input type="text" class="form-control" maxlength="50" id="com_' . $qtd . '" name="com[]"
                         value="' . $lin['endcomplemento'] . '" />
               </div>
               <div class="col-md-2"></div>
          </div>
          <div class="row">
               <div class="col-md-6">
                    <label>Bairro</label>
                    <input type="text" class="form-control" maxlength="50" id="bai_' . $qtd . '" name="bai[]"
                         value="' . $lin['endbairro'] . '" />
               </div>
               <div class="col-md-5">
                    <label>Cidade</label>
                    <input type="text" class="form-control" maxlength="30" id="cid_' . $qtd . '" name="cid[]"
                         value="' . $lin['endcidade'] . '" />
               </div>
               <div class="col-md-1">
                    <label>Estado</label>
                    <input type="text" class="form-control" maxlength="2" id="est_' . $qtd . '" name="est[]"
                         value="' . $lin['endestado'] . '" required />
               </div>
          </div>
          <div class="row">
               <div class="col-md-4">
                    <label>Telefone</label>
                    <input type="text" class="form-control" maxlength="15" id="tel_' . $qtd . '" name="tel[]"
                         value="' . $lin['endtelefone'] . '" />
               </div>
               <div class="col-md-4">
                    <label>Celular</label>
                    <input type="text" class="form-control" maxlength="15" id="cel_' . $qtd . '" name="cel[]"
                         value="' . $lin['endcelular'] . '" />
               </div>
               <div class="col-md-4">
                    <label>E-Mail</label>
                    <input type="email" class="form-control" maxlength="75" id="ema_' . $qtd . '" name="ema[]"
                         value="' . $lin['endemail'] . '" />
               </div>
          </div>';
          $txt .= '</div>';
          $qtd = $qtd + 1;
     }
     return $txt;
 }

 function consiste_cli() {
     $sta = 0;
     if (trim($_REQUEST['ape']) == "") {
          $_REQUEST['ape'] = primeiro_nom($_REQUEST['nom']);
     }
     if (trim($_REQUEST['nom']) == "") {
          echo '<script>alert("Nome do cliente informado não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['cep'][0]) == "") {
          echo '<script>alert("Número do Cep do cliente não pode estar em branco");</script>';
          return 2;
     }
     if (trim($_REQUEST['cpf']) == "" || trim($_REQUEST['cpf']) == "../-") {
          echo '<script>alert("Número do C.p.f. do cliente não pode estar em branco");</script>';
          return 3;
     }
     if (valida_est(strtoupper($_REQUEST['est'][0])) == 0) {
          echo '<script>alert("Estado da Federação do cliente informado não é válido");</script>';
          return 4;
     }
     if ($_REQUEST['cpf'] != "") {
          $sta = valida_cpf($_REQUEST['cpf']);
          if ($sta != 0) {
               echo '<script>alert("Dígito de controle do C.p.f. não está correto");</script>';
               return 5;
          }
     }    
     $nro = count($_REQUEST['est']);
     for ($ind = 0; $ind < $nro; $ind++) {
          if ($_REQUEST['est'][$ind] != "") {
               if (valida_est(strtoupper($_REQUEST['est'][$ind])) == 0) {
                    echo '<script>alert("Estado da Federação do cliente informado não está correto");</script>';
                    return 6;
               }
          }
     }
     return $sta;
}

function incluir_cli() {
     $ret = 0;
     include_once "dados.php";
     $num = str_replace(".", "", $_REQUEST['num'][0]); $num = str_replace(",", ".", $num);
     $sql  = "insert into tb_cliente (";
     $sql .= "cliempresa, ";
     $sql .= "clistatus, ";
     $sql .= "clinome, ";
     $sql .= "clisuite, ";
     $sql .= "clisenha, ";
     $sql .= "clifantasia, ";
     $sql .= "clicpf, ";
     $sql .= "cliregistro, ";
     $sql .= "cliobservacao, ";
     $sql .= "clititulo, ";
     $sql .= "clicep, ";
     $sql .= "cliendereco, ";
     $sql .= "clinumero, ";
     $sql .= "clicomplemento, ";
     $sql .= "clibairro, ";
     $sql .= "clicidade, ";
     $sql .= "cliestado, ";
     $sql .= "clitelefone, ";
     $sql .= "clicelular, ";
     $sql .= "cliemail, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['nom']) . "',";
     $sql .= "'" . $_REQUEST['sui'] . "',";
     $sql .= "'" . base64_encode($_REQUEST['sen']) . "',";
     $sql .= "'" . $_REQUEST['ape'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cpf']) . "',";
     $sql .= "'" . $_REQUEST['reg'] . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['obs']) . "',";     
     $sql .= "'" . $_REQUEST['tit'][0] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cep'][0]) . "',";
     $sql .= "'" . $_REQUEST['end'][0] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['num'][0]) . "',";
     $sql .= "'" . $_REQUEST['com'][0] . "',";
     $sql .= "'" . $_REQUEST['bai'][0] . "',";
     $sql .= "'" . $_REQUEST['cid'][0] . "',";
     $sql .= "'" . strtoupper($_REQUEST['est'][0]) . "',";
     $sql .= "'" . $_REQUEST['tel'][0] . "',";
     $sql .= "'" . $_REQUEST['cel'][0] . "',";
     $sql .= "'" . $_REQUEST['ema'][0] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     $_SESSION['wrkcodreg'] = $ult;
     $_SESSION['wrkcodcli'] = $ult;
     $_SESSION['wrkcodsui'] = $_REQUEST['sui'];
     if ($ret == true) {
          echo '<script>alert("Registro incluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
 }

 function incluir_end() {
     $ret = 0;
     include_once "dados.php";
     if ($_SESSION['wrkopereg'] == 2) {
          $sql  = "delete from tb_cliente_e where endcliente = " . $_SESSION['wrkcodreg'] ;
          $ret = comando_tab($sql, $nro, $ult, $men);
          if ($ret == false) {
               print_r($sql);
               echo '<script>alert("Erro na deleção dos endereços do cliente !");</script>';
          }     
     }
     $qtd = count($_REQUEST['end']);
     for ($ind = 1; $ind < $qtd; $ind++) {
          if ($_REQUEST['end'][$ind] != "") {
               $sql  = "insert into tb_cliente_e (";
               $sql .= "endempresa, ";
               $sql .= "endstatus, ";
               $sql .= "endcliente, ";
               $sql .= "endtitulo, ";
               $sql .= "endcep, ";
               $sql .= "endendereco, ";
               $sql .= "endnumero, ";
               $sql .= "endcomplemento, ";
               $sql .= "endbairro, ";
               $sql .= "endcidade, ";
               $sql .= "endestado, ";
               $sql .= "endtelefone, ";
               $sql .= "endcelular, ";
               $sql .= "endemail, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . $_REQUEST['sta'] . "',";
               $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
               $sql .= "'" . $_REQUEST['tit'][$ind] . "',";
               $sql .= "'" . limpa_nro($_REQUEST['cep'][$ind]) . "',";
               $sql .= "'" . $_REQUEST['end'][$ind] . "',";
               $sql .= "'" . limpa_nro($_REQUEST['num'][$ind]) . "',";
               $sql .= "'" . $_REQUEST['com'][$ind] . "',";
               $sql .= "'" . $_REQUEST['bai'][$ind] . "',";
               $sql .= "'" . $_REQUEST['cid'][$ind] . "',";
               $sql .= "'" . strtoupper($_REQUEST['est'][$ind]) . "',";
               $sql .= "'" . $_REQUEST['tel'][$ind] . "',";
               $sql .= "'" . $_REQUEST['cel'][$ind] . "',";
               $sql .= "'" . $_REQUEST['ema'][$ind] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = comando_tab($sql, $nro, $ult, $men);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
               }     
          }
     }
 }

 function alterar_cli() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "update tb_cliente set ";
     $sql .= "clinome = '". $_REQUEST['nom'] . "', ";
     $sql .= "clistatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "clisuite = '". $_REQUEST['sui'] . "', ";
     $sql .= "clisenha = '". base64_encode($_REQUEST['sen']) . "', ";
     $sql .= "clifantasia = '". $_REQUEST['ape'] . "', ";
     $sql .= "cliregistro = '". $_REQUEST['reg'] . "', ";
     $sql .= "clicpf = '". limpa_nro($_REQUEST['cpf']) . "', ";
     $sql .= "cliobservacao = '". str_replace("'", "´", $_REQUEST['obs']) . "', ";
     $sql .= "clititulo = '". $_REQUEST['tit'][0] . "', ";
     $sql .= "clicep = '". limpa_nro($_REQUEST['cep'][0]) . "', ";
     $sql .= "cliendereco = '". $_REQUEST['end'][0] . "', ";
     $sql .= "clinumero = '". limpa_nro($_REQUEST['num'][0]) . "', ";
     $sql .= "clicomplemento = '". $_REQUEST['com'][0] . "', ";
     $sql .= "clibairro = '". $_REQUEST['bai'][0] . "', ";
     $sql .= "clicidade = '". $_REQUEST['cid'][0] . "', ";
     $sql .= "cliestado = '". strtoupper($_REQUEST['est'][0]) . "', ";
     $sql .= "clitelefone = '". $_REQUEST['tel'][0] . "', ";
     $sql .= "clicelular = '". $_REQUEST['cel'][0] . "', ";
     $sql .= "cliemail = '". $_REQUEST['ema'][0] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idcliente = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 }   
     
 function excluir_cli() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_cliente_e where endcliente = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do endereço do cliente !");</script>';
     }
     $sql  = "delete from tb_cliente where idcliente = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro excluído no sistema com Sucesso !");</script>';
     } else {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }


?>

</html>