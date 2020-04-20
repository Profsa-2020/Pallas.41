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
     $("#pes").mask("999.999,9999", {
          reverse: true
     });
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
     $dat = (isset($_REQUEST['dat']) == false ? date('d/m/Y')  : $_REQUEST['dat']);
     $hor = (isset($_REQUEST['hor']) == false ? date('H:m')  : $_REQUEST['hor']);
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
               $ret = consiste_mov();
               if ($ret == 0) {
                    $ret = incluir_mov();
                    $ret = gravar_log(11,"Inclusão de novo movimento: " . $des);
                    $sta = 0; $dat = ''; $hor = ''; $tip = ''; $qtd = ''; $cli = 0; $tra = 0; $pro = 0; $pre = ''; $obs = ''; $cod = ultimo_cod();
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_mov();
               if ($ret == 0) {
                    $ret = alterar_mov();
                    $ret = gravar_log(12,"Alteração de movimento existente: " . $des); $_SESSION['wrkmostel'] = 0;
                    $sta = 0; $des = ''; $uni = ''; $key = ''; $gru = 0; $loc = 0; $cli = 0; $sui = ''; $est = 0; $pes = ''; $pre = '';  $obs = ''; $cod = ultimo_cod();
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_mov();
               $ret = gravar_log(13,"Exclusão de movimento existente: " . $des); $_SESSION['wrkmostel'] = 0;
               $sta = 0; $des = ''; $uni = ''; $key = ''; $gru = 0; $loc = 0; $cli = 0; $sui = ''; $est = 0; $pes = ''; $pre = '';  $obs = ''; $cod = ultimo_cod();
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
     }

     ?>

<body id="box00">
     <h1 class="cab-0">MyLogBox - Manutenção Movimento - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <div class="row qua-2">
                    <div class="col-md-11 text-left">
                         <span>Manutenção de Movimento</span>
                    </div>
                    <div class="col-md-1">
                         <form name="frmTelNov" action="man-movto.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Mostra campos para criar novo movimento no sistema"><i
                                             class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                              </div>
                         </form>
                    </div>
               </div>

               <form class="tel-1" name="frmTelMan" action="" method="POST">
                    <div class="row">
                         <div class="col-md-2">
                              <label>Número</label>
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
                         <div class="col-md-10">
                              <label>Descrição do Produto</label>
                              <input type="text" class="form-control" maxlength="100" id="des" name="des"
                                   value="<?php echo $des; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Unidade de Medida</label>
                              <input type="text" class="form-control text-center" maxlength="5" id="uni" name="uni"
                                   value="<?php echo $uni; ?>" />
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-5"></div>
                         <div class="col-md-2">
                              <label>Suite</label>
                              <input type="text" class="form-control text-center" maxlength="15" id="sui" name="sui"
                                   value="<?php echo $sui ?>" />
                         </div>
                         <div class="col-md-5"></div>
                    </div>

                    <div class="row">
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Cliente (proprietário) </label>
                              <select id="cli" name="cli" class="form-control">
                                   <?php $ret = carrega_cli($cli); ?>
                              </select>
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-6">
                              <label>Grupo do Produto</label>
                              <select id="gru" name="gru" class="form-control">
                                   <?php $ret = carrega_gru($gru); ?>
                              </select>
                         </div>
                         <div class="col-md-6">
                              <label>Local do Produto</label>
                              <select id="loc" name="loc" class="form-control">
                                   <?php $ret = carrega_loc($loc); ?>
                              </select>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-2">
                              <label>Código</label>
                              <input type="text" class="form-control" maxlength="15" id="key" name="key"
                                   value="<?php echo $key; ?>" />
                         </div>
                         <div class="col-md-2">
                              <label>Peso (libras)</label>
                              <input type="text" class="form-control text-right" maxlength="15" id="pes" name="pes"
                                   value="<?php echo $pes ?>" />
                         </div>
                         <div class="col-md-2">
                              <label>Preço Unitário</label>
                              <input type="text" class="form-control text-right" maxlength="15" id="pre" name="pre"
                                   value="<?php echo $pre ?>" />
                         </div>
                         <div class="col-md-3"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                              <label>Observação</label>
                              <textarea class="form-control" rows="3" id="obs" name="obs"><?php echo $obs ?></textarea>
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-md-2 text-center">
                              <div class="lit-2">
                                   <?php echo 'Estoque: ' . $est; ?>
                              </div>
                         </div>
                         <div class="col-md-8 text-center">
                              <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                   class="bot-1"><?php echo $bot; ?></button>
                         </div>
                         <div class="col-md-2 text-center">
                              <button type="button" class="bot-2" name="doc_carrega" id="doc_carrega"
                                   title="Abre janela para carregar anexos para o produto, imagens e videos."><i
                                        class="fa fa-upload fa-3x" aria-hidden="true"></i></button>
                         </div>

                    </div>
                    <br />
                    <div class="row">
                         <div class="col-md-12 text-center">
                              <?php
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                   ?>
                         </div>
                    </div>
                    <br />
               </form>
          </div>
          <br />
</body>

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

function consiste_mov() {
     $sta = 0;
     if (trim($_REQUEST['dat']) == "") {
          echo '<script>alert("Data do movimento informado não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['qtd']) == "" || trim($_REQUEST['qtd']) == 0) {
          echo '<script>alert("Quantidade do movimento informado não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['tra']) == "" || trim($_REQUEST['tra']) == 0) {
          echo '<script>alert("Código da transação do movimento não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['pro']) == "" || trim($_REQUEST['pro']) == 0) {
          echo '<script>alert("Código do produto do movimento não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['cli']) == "" || trim($_REQUEST['cli']) == 0) {
          echo '<script>alert("Código do cliente do movimento não pode estar em branco");</script>';
          return 1;
     }
     return $sta;
}

function incluir_mov() {
     $ret = 0;
     include_once "dados.php";
     $qtd = str_replace(".", "", $_REQUEST['qtd']); $qtd = str_replace(",", ".", $qtd);
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     $emi = substr($_REQUEST['emi'],6,4) . "-" . substr($_REQUEST['emi'],3,2) . "-" . substr($_REQUEST['emi'],0,2);
     $sql  = "insert into tb_movto (";
     $sql .= "movempresa, ";
     $sql .= "movstatus, ";
     $sql .= "movproduto, ";
     $sql .= "movdata, ";
     $sql .= "movcliente, ";
     $sql .= "movtransacao, ";
     $sql .= "movtipo, ";
     $sql .= "movgrupo, ";
     $sql .= "movlocal, ";
     $sql .= "movsuite, ";
     $sql .= "movquantidade, ";
     $sql .= "movpreco, ";
     $sql .= "movvalor, ";
     $sql .= "movdolarent, ";
     $sql .= "movdolarsai, ";
     $sql .= "movobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['des']) . "',";
     $sql .= "'" . $_REQUEST['uni'] . "',";
     $sql .= "'" . $_REQUEST['key'] . "',";
     $sql .= "'" . $_REQUEST['gru'] . "',";
     $sql .= "'" . $_REQUEST['loc'] . "',";
     $sql .= "'" . ($pes == "" ? 0 : $pes) . "',";
     $sql .= "'" . ($pre == "" ? 0 : $pre) . "',";
     $sql .= "'" . $_REQUEST['cli'] . "',";
     $sql .= "'" . $_REQUEST['sui'] . "',";
     $sql .= "'" . $_REQUEST['obs'] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     $_SESSION['wrkcodreg'] = $ult;
     if ($ret == true) {
          echo '<script>alert("Registro incluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
 }

 function alterar_mov() {
     $ret = 0;
     $qtd = str_replace(".", "", $_REQUEST['qtd']); $qtd = str_replace(",", ".", $qtd);
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     $emi = substr($_REQUEST['emi'],6,4) . "-" . substr($_REQUEST['emi'],3,2) . "-" . substr($_REQUEST['emi'],0,2);
     include_once "dados.php";
     $sql  = "update tb_movtoo set ";
     $sql .= "movproduto = '". $_REQUEST['des'] . "', ";
     $sql .= "movdata = '". $_REQUEST['sta'] . "', ";
     $sql .= "movcliente = '". $_REQUEST['cli'] . "', ";
     $sql .= "movproduto = '". $_REQUEST['pro'] . "', ";
     $sql .= "movtransacao = '". $_REQUEST['tra'] . "', ";
     $sql .= "movtipo = '". $_REQUEST['gru'] . "', ";
     $sql .= "movgrupo = '". $_REQUEST['loc'] . "', ";
     $sql .= "movlocal = '". $pes . "', ";
     $sql .= "movsuite = '". $pre . "', ";
     $sql .= "movquantidade = '". $qtd . "', ";
     $sql .= "movpreco = '". $pre . "', ";
     $sql .= "movvalor = '". $_REQUEST['sui'] . "', ";
     $sql .= "movobservacao = '". str_replace("'", "´", $_REQUEST['obs']) . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idmovto = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 }   
     
 function excluir_mov() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_movto where idmovto = " . $_SESSION['wrkcodreg'] ;
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