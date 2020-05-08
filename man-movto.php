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
     $("#hor").mask("00:00");
     $("#qtd").mask("000.000", {
          reverse: true
     });
     $("#pre").mask("000.000,00", {
          reverse: true
     });
     $("#pes").mask("000.000,0000", {
          reverse: true
     });
     $("#dat").datepicker($.datepicker.regional["pt-BR"]);
});


$(document).ready(function() {
     $("#sui").blur(function() {
          var tip = 0;
          var cli = $('#cli').val();
          var sui = $('#sui').val();
          var pro = $('#pro').val();
          $.getJSON("carrega-sui.php", {
                    tip: tip,
                    cli: cli,
                    sui: sui
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
                    if (data.cli != 0) {
                         $('#cli').val(data.cli);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento de suite para o cliente");
               });

          $.getJSON("carrega-pro.php", {
                    cli: cli,
                    pro: pro
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
                    if (data.txt != "") {
                         $('#pro').html(data.txt);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento de produtos do cliente");
               });

     });

     $("#tra").change(function() {
          var ret = calculo_qtd();
     });

     $("#pro").change(function() {
          var ret = calculo_qtd();
          var pro = $('#pro').val();
          var pre = $('#pre').val();
          $.getJSON("carrega-pre.php", {
                    pro: pro,
                    pre: pre
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
                    if (data.pes != "") {
                         $('#pes').val(data.pes);
                    }
                    if (data.pre != "") {
                         $('#pre').val(data.pre);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento do preço do produto");
               });
     });

     $("#qtd").blur(function() {
          var ret = calculo_qtd();
          var pro = $('#pro').val();
          var pre = $('#pre').val();
          var pes = $('#pes').val();
          var qtd = $('#qtd').val();
          $.getJSON("calculo-pes.php", {
                    pro: pro,
                    qtd: qtd,
                    pes: pes,
                    pre: pre
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
                    if (data.pes != "") {
                         $('#pes').val(data.pes);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no calculo no peso do produto");
               });

     });

     $("#pes").blur(function() {
          var ret = calculo_qtd();
     });


     $("#cli").change(function() {
          var tip = 1;
          var cli = $('#cli').val();
          var sui = $('#sui').val();
          var pro = $('#pro').val();
          $.getJSON("carrega-sui.php", {
                    tip: tip,
                    cli: cli,
                    sui: sui
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    } else {
                         $('#sui').val(data.sui);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento de suite do cliente");
               });

          $.getJSON("carrega-pro.php", {
                    cli: cli,
                    pro: pro
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
                    if (data.txt != "") {
                         $('#pro').html(data.txt);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento de produtos do cliente");
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

});

function calculo_qtd() {
     var ret = 0;
     var tra = $('#tra').val();
     var pro = $('#pro').val();
     var qtd = $('#qtd').val();
     var pes = $('#pes').val();
     var pre = $('#pre').val();
     $.getJSON("calculo-qtd.php", {
               tra: tra,
               pro: pro,
               qtd: qtd,
               pes: pes,
               pre: pre
          })
          .done(function(data) {
               if (data.men != "") {
                    $('#qtd').val('');
                    alert(data.men);
               }
               if (data.txt != "") {
                    $('#dad-cal').html(data.txt);
               }
          }).fail(function(data) {
               console.log(data);
               alert("Erro ocorrido no processamento do calculo de estoque");
          });

     return qtd;
}
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
     $hor = (isset($_REQUEST['hor']) == false ? date('H:i')  : $_REQUEST['hor']);
     $tip = (isset($_REQUEST['tip']) == false ? '' : $_REQUEST['tip']);
     $qtd = (isset($_REQUEST['qtd']) == false ? '' : $_REQUEST['qtd']);
     $pes = (isset($_REQUEST['pes']) == false ? '' : $_REQUEST['pes']);
     $sui = (isset($_REQUEST['sui']) == false ? '' : $_REQUEST['sui']);
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
               $ret = ler_movto($cha, $dat, $sta, $hor, $tip, $qtd, $pes, $cli, $sui, $tra, $pro, $pre, $obs); 
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $ret = consiste_mov();
               if ($ret == 0) {
                    $ret = incluir_mov();
                    $ret = estoque_ind($pro, $qtd_e, $pes_e);
                    $ret = atualiza_est($pro, $qtd_e, $pes_e);
                    $ret = gravar_log(11,"Inclusão de novo movimento: " . $dat . " " . $hor);
                    $sta = 0; $dat = ''; $hor = ''; $tip = ''; $qtd = ''; $pes = ''; $cli = 0; $tra = 0; $pro = 0; $pre = ''; $obs = ''; $cod = ultimo_cod();
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_mov();
               if ($ret == 0) {
                    $ret = alterar_mov();
                    $ret = estoque_ind($pro, $qtd_e, $pes_e);
                    $ret = atualiza_est($pro, $qtd_e, $pes_e);
                    $ret = gravar_log(12,"Alteração de movimento existente: " . $dat . " " . $hor); $_SESSION['wrkmostel'] = 0;
                    $sta = 0; $dat = ''; $hor = ''; $tip = ''; $qtd = ''; $pes = ''; $cli = 0; $tra = 0; $pro = 0; $pre = ''; $obs = ''; $cod = ultimo_cod();
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_mov();
               $ret = estoque_ind($pro, $qtd_e, $pes_e);
               $ret = atualiza_est($pro, $qtd_e, $pes_e);
               $ret = gravar_log(13,"Exclusão de movimento existente: " . $dat . " " . $hor); $_SESSION['wrkmostel'] = 0;
               $sta = 0; $dat = ''; $hor = ''; $tip = ''; $qtd = ''; $pes = ''; $cli = 0; $tra = 0; $pro = 0; $pre = ''; $obs = ''; $cod = ultimo_cod();
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
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Transação para Estoque </label>
                              <select id="tra" name="tra" class="form-control" required>
                                   <?php $ret = carrega_tra($tra); ?>
                              </select>
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-4"></div>
                         <div class="col-md-2">
                              <label>Data do Movimento</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="dat" name="dat"
                                   value="<?php echo $dat; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Hora do Movimento</label>
                              <input type="text" class="form-control text-center" maxlength="5" id="hor" name="hor"
                                   value="<?php echo $hor; ?>" required />
                         </div>
                         <div class="col-md-4"></div>
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
                         <div class="col-md-2"></div>
                         <div class="col-md-8">
                              <label>Produto Desejado</label>
                              <select id="pro" name="pro" class="form-control">
                                   <?php $ret = carrega_pro($cli, $pro); ?>
                              </select>
                         </div>
                         <div class="col-md-2"></div>
                    </div>
                    <div class="row">
                         <div class="col-md-3"></div>
                         <div class="col-md-2">
                              <label>Quantidade</label>
                              <input type="text" class="form-control text-right" maxlength="15" id="qtd" name="qtd"
                                   value="<?php echo $qtd; ?>" />
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
                              <textarea class="form-control" rows="2" id="obs" name="obs"><?php echo $obs ?></textarea>
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-md-12 text-center">
                              <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                   class="bot-1"><?php echo $bot; ?></button>
                         </div>
                    </div>
                    <br />
                    <div class="row text-center">
                         <div id="dad-cal" class="cor-2 col-md-12"></div>
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
          <div id="box10">
               <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
          </div>
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

function carrega_tra($tra) {
     $sta = 0;
     include_once "dados.php";    
     if ($tra == 0) {
          echo '<option value="0" selected="selected">Selecione transação desejada ...</option>';
     }
     $com = "Select idgrupo, grudescricao from tb_grupo where grustatus = 0 and grutiporeg = 3 and gruempresa = " . $_SESSION['wrkcodemp'] . " order by grudescricao";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idgrupo'] != $tra) {
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

function carrega_pro($cli, $pro) {
     $sta = 0;
     include_once "dados.php";    
     if ($pro == 0) {
          echo '<option value="0" selected="selected">Selecione produto desejado ...</option>';
     }
     $com = "Select idproduto, prodescricao from tb_produto where prostatus = 0  and proempresa = " . $_SESSION['wrkcodemp'] . " and procliente = " . $cli . " order by prodescricao";
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

function ler_movto($cha, &$dat, &$sta, &$hor, &$tip, &$qtd, &$pes, &$cli, &$sui, &$tra, &$pro, &$pre, &$obs) {
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
          $sui = $lin['movsuite'];
          $tra = $lin['movtransacao'];
          $pro = $lin['movproduto'];
          $cli = $lin['movcliente'];
          $obs = $lin['movobservacao'];
          $pre = number_format($lin['movpreco'], 2, ",", ".");
          $pes = number_format($lin['movpeso'], 4, ",", ".");
          $qtd = number_format($lin['movquantidade'], 0, ",", ".");
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
     if ($_REQUEST['dat'] != "") {
          if (valida_dat($_REQUEST['dat']) != 0) {
               echo '<script>alert("Data do movimento informada não é valida");</script>';
               return 4;
          }
     }
     if ($_REQUEST['hor'] != "") {
          if (valida_hor($_REQUEST['hor']) != 0) {
               echo '<script>alert("Hora do movimento informada não é valida");</script>';
               return 4;
          }
     }
     return $sta;
}

function incluir_mov() {
     $ret = 0; $tip = 0; $gru = 0; $loc = 0;
     include_once "dados.php";
     $nro = quantidade_reg("Select idgrupo, grutipogru from tb_grupo where idgrupo = " . $_REQUEST['tra'], $men, $lin);     
     if ($nro == 1 || $lin == true) {
          $tip = $lin['grutipogru']; 
     }     
     $nro = quantidade_reg("Select idproduto, progrupo, prolocal from tb_produto where idproduto = " . $_REQUEST['pro'], $men, $lin);     
     if ($nro == 1 || $lin == true) {
          $loc = $lin['prolocal']; 
          $gru = $lin['progrupo']; 
     }     
     $qtd = str_replace(".", "", $_REQUEST['qtd']); $qtd = str_replace(",", ".", $qtd);
     $pes = str_replace(".", "", $_REQUEST['pes']); $pes = str_replace(",", ".", $pes);
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     $dat = substr($_REQUEST['dat'],6,4) . "-" . substr($_REQUEST['dat'],3,2) . "-" . substr($_REQUEST['dat'],0,2) . " " . $_REQUEST['hor'];
     if ($pre == "") { $pre = 0; }
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
     $sql .= "movpeso, ";
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
     $sql .= "'" . $_REQUEST['pro'] . "',";
     $sql .= "'" . $dat . "',";
     $sql .= "'" . $_REQUEST['cli'] . "',";
     $sql .= "'" . $_REQUEST['tra'] . "',";
     $sql .= "'" . $tip . "',";
     $sql .= "'" . $gru . "',";
     $sql .= "'" . $loc . "',";
     $sql .= "'" . $_REQUEST['sui'] . "',";
     $sql .= "'" . ($pes == "" ? 0 : $pes) . "',";
     $sql .= "'" . ($qtd == "" ? 0 : $qtd) . "',";
     $sql .= "'" . ($pre == "" ? 0 : $pre) . "',";
     $sql .= "'" . round($qtd * $pre, 4) . "',";
     $sql .= "'" . ($tip == 2 ? 0 : $_SESSION['wrkdoldia']) . "',";
     $sql .= "'" . ($tip == 1 ? 0 : $_SESSION['wrkdoldia']) . "',";
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
     $ret = 0; $tip = 0; $gru = 0; $loc = 0;
     include_once "dados.php";
     $nro = quantidade_reg("Select idgrupo, grutipogru from tb_grupo where idgrupo = " . $_REQUEST['tra'], $men, $lin);     
     if ($nro == 1 || $lin == true) {
          $tip = $lin['grutipogru']; 
     }     
     $nro = quantidade_reg("Select idproduto, progrupo, prolocal from tb_produto where idproduto = " . $_REQUEST['pro'], $men, $lin);     
     if ($nro == 1 || $lin == true) {
          $loc = $lin['prolocal']; 
          $gru = $lin['progrupo']; 
     }     
     $qtd = str_replace(".", "", $_REQUEST['qtd']); $qtd = str_replace(",", ".", $qtd);
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     $dat = substr($_REQUEST['dat'],6,4) . "-" . substr($_REQUEST['dat'],3,2) . "-" . substr($_REQUEST['dat'],0,2) . " " . $_REQUEST['hor'];
     if ($pre == "") { $pre = 0; }
     $sql  = "update tb_movto set ";
     $sql .= "movproduto = '". $_REQUEST['pro'] . "', ";
     $sql .= "movdata = '". $dat . "', ";
     $sql .= "movcliente = '". $_REQUEST['cli'] . "', ";
     $sql .= "movtransacao = '". $_REQUEST['tra'] . "', ";
     $sql .= "movtipo = '". $tip . "', ";
     $sql .= "movgrupo = '". $gru . "', ";
     $sql .= "movlocal = '". $loc . "', ";
     $sql .= "movsuite = '". $_REQUEST['sui'] . "', ";
     $sql .= "movpeso = '". ($pes == "" ? 0 : $pes) . "', ";
     $sql .= "movquantidade = '". ($qtd == "" ? 0 : $qtd) . "', ";     
     $sql .= "movpreco = '". ($pre == "" ? 0 : $pre) . "', ";
     $sql .= "movvalor = '". round($qtd * $pre, 2) . "', ";
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