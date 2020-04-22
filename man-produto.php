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
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Produtos</title>
</head>

<script>
$(function() {
     $("#cpf").mask("000.000.000-00");
     $("#qd").mask("999.999", { reverse: true });
     $("#pre").mask("999.999,99", { reverse: true });
     $("#pes").mask("999.999,9999", { reverse: true });
     $("#dat").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {
     $("#sui").blur(function() {
          var cli = $('#cli').val();
          var sui = $('#sui').val();
          $.getJSON("carrega-sui.php", {
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
     });

     $("#cli").change(function() {
          var cli = $('#cli').val();
          var sui = $('#sui').val();
          $.getJSON("carrega-sui.php", {
                    cli: cli,
                    sui: sui
               })
               .done(function(data) {
                    if (data.men != "") {
                         alert(data.men);
                    }
                    if (data.sui != "") {
                         $('#sui').val(data.sui);
                    }
               }).fail(function(data) {
                    console.log(data);
                    alert("Erro ocorrido no processamento de suite do cliente");
               });
     });

     $('#doc_carrega').bind("click", function() {
          $('#doc_janela').click();
     });
     $('#doc_janela').change(function() {
          var path = $('#doc_janela').val();
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
               $ret = gravar_log(6,"Entrada na página de manutenção de produtos do sistema Pallas.41 - MyLogBox do Brasil");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0  : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0  : $_REQUEST['sta']);
     $uni = (isset($_REQUEST['uni']) == false ? 'PÇ'  : $_REQUEST['uni']);
     $key = (isset($_REQUEST['key']) == false ? '' : $_REQUEST['key']);
     $gru = (isset($_REQUEST['gru']) == false ? '' : $_REQUEST['gru']);
     $loc = (isset($_REQUEST['loc']) == false ? '' : $_REQUEST['loc']);
     $pes = (isset($_REQUEST['pes']) == false ? '' : $_REQUEST['pes']);
     $qtd = (isset($_REQUEST['qtd']) == false ? '1' : $_REQUEST['qtd']);
     $pre = (isset($_REQUEST['pre']) == false ? '' : $_REQUEST['pre']);
     $cli = (isset($_REQUEST['cli']) == false ? $_SESSION['wrkcodcli'] : $_REQUEST['cli']);
     $sui = (isset($_REQUEST['sui']) == false ? $_SESSION['wrkcodsui'] : $_REQUEST['sui']);
     $est = (isset($_REQUEST['est']) == false ? '' : $_REQUEST['est']);
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de produto informado em tela ?\')" ';
     }  

     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
               $ret = ler_produto($cha, $des, $sta, $uni, $key, $gru, $loc, $pes, $pre, $cli, $sui, $est, $qtd, $obs); 
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $_SESSION['wrkcodreg'] = ultimo_cod();               
               $ret = consiste_pro();
               if ($ret == 0) {
                    $ret = incluir_pro();
                    $ret = processa_mov();
                    $ret = estoque_ind($_SESSION['wrkcodreg'], $qtd_e, $pes_e);
                    $ret = atualiza_est($_SESSION['wrkcodreg'], $qtd_e, $pes_e);
                    $ret = gravar_log(11,"Inclusão de novo produto: " . $des);
                    $sta = 0; $des = ''; $uni = ''; $key = ''; $gru = 0; $loc = 0; $cli = 0; $sui = ''; $est = $qtd_e; $pes = ''; $qtd = 1; $pre = '';  $obs = ''; $cod = ultimo_cod();
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_pro();
               if ($ret == 0) {
                    $ret = alterar_pro();
                    $ret = processa_mov();
                    $ret = estoque_ind($_SESSION['wrkcodreg'], $qtd_e, $pes_e);
                    $ret = atualiza_est($_SESSION['wrkcodreg'], $qtd_e, $pes_e);
                    $ret = gravar_log(12,"Alteração de produto existente: " . $des); $_SESSION['wrkmostel'] = 0;
                    $sta = 0; $des = ''; $uni = ''; $key = ''; $gru = 0; $loc = 0; $cli = 0; $sui = ''; $est = $qtd_e; $pes = ''; $qtd = 1; $pre = '';  $obs = ''; $cod = ultimo_cod();
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_pro();
               $ret = estoque_ind($_SESSION['wrkcodreg'], $qtd_e, $pes_e);
               $ret = atualiza_est($_SESSION['wrkcodreg'], $qtd_e, $pes_e);
               $ret = gravar_log(13,"Exclusão de produto existente: " . $des); $_SESSION['wrkmostel'] = 0;
               $sta = 0; $des = ''; $uni = ''; $key = ''; $gru = 0; $loc = 0; $cli = 0; $sui = ''; $est = 0; $pes = ''; $qtd = 1; $pre = '';  $obs = ''; $cod = ultimo_cod();
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
     }
?>

<body id="box00">
     <h1 class="cab-0">MyLogBox - Manutenção Produtos - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <div class="row qua-2">
                    <div class="col-md-11 text-left">
                         <span>Manutenção de Produtos</span>
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

               <form class="tel-1" name="frmTelMan" action="" method="POST" enctype="multipart/form-data">
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
                         <div class="col-md-2"></div>
                         <div class="col-md-2">
                              <label>Código</label>
                              <input type="text" class="form-control" maxlength="15" id="key" name="key"
                                   value="<?php echo $key; ?>" />
                         </div>
                         <div class="col-md-2">
                              <label>Quantidade</label>
                              <input type="text" class="form-control text-right" maxlength="15" id="qtd" name="qtd"
                                   value="<?php echo $qtd; ?>" />
                         </div>
                         <div class="col-md-2">
                              <label>Peso Total (libras)</label>
                              <input type="text" class="form-control text-right" maxlength="15" id="pes" name="pes"
                                   value="<?php echo $pes ?>" />
                         </div>
                         <div class="col-md-2">
                              <label>Preço Unitário</label>
                              <input type="text" class="form-control text-right" maxlength="15" id="pre" name="pre"
                                   value="<?php echo $pre ?>" />
                         </div>
                         <div class="col-md-2"></div>
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
                    <input name="anexo[]" type="file" id="doc_janela" class="bot-4" multiple="multiple" accept=".jpg, .jpeg, .png, .mp4, .avi" />
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
     $nro = quantidade_reg('Select idproduto, prodescricao from tb_produto order by idproduto desc Limit 1', $men, $reg);     
     if ($nro == 1) {
          $cod = $reg['idproduto'] + 1;
     }
     return $cod;
}

function carrega_gru($gru) {
     $sta = 0;
     include_once "dados.php";    
     if ($gru == 0) {
          echo '<option value="0" selected="selected">Selecione grupo de produto desejado ...</option>';
     }
     $com = "Select idgrupo, grudescricao from tb_grupo where grustatus = 0 and grutiporeg = 1 and gruempresa = " . $_SESSION['wrkcodemp'] . " order by grudescricao";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idgrupo'] != $gru) {
               echo  '<option value ="' . $lin['idgrupo'] . '">' . $lin['grudescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $lin['idgrupo'] . '" selected="selected">' . $lin['grudescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_loc($loc) {
     $sta = 0;
     include_once "dados.php";    
     if ($loc == 0) {
          echo '<option value="0" selected="selected">Selecione local de produto desejado ...</option>';
     }
     $com = "Select idgrupo, grudescricao from tb_grupo where grustatus = 0 and grutiporeg = 2 and gruempresa = " . $_SESSION['wrkcodemp'] . " order by grudescricao";
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
          echo '<option value="0" selected="selected">Selecione cliente para o produto desejado ...</option>';
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

function ler_produto($cha, &$des, &$sta, &$uni, &$key, &$gru, &$loc, &$pes, &$pre, &$cli, &$sui, &$est, &$qtd, &$obs) {
     include_once "dados.php";
     $nro = quantidade_reg("Select * from tb_produto where idproduto = " . $cha, $men, $lin);     
     if ($nro == 0 || $lin == false) {
          echo '<script>alert("Código do produto informado não cadastrado");</script>';
          $nro = 1;
     } else {
          $cha = $lin['idproduto'];
          $des = $lin['prodescricao'];
          $sta = $lin['prostatus'];
          $uni = $lin['prounidade'];
          $key = $lin['procodigo'];
          $gru = $lin['progrupo'];
          $loc = $lin['prolocal'];
          $cli = $lin['procliente'];
          $sui = $lin['prosuite'];
          $obs = $lin['proobservacao'];
          $est = number_format($lin['proestoqueqtd'], 0, ",", ".");
          $pes = number_format($lin['propeso'], 4, ",", ".");
          $qtd = number_format($lin['proquantidade'], 0, ",", ".");
          $pre = number_format($lin['propreco'], 2, ",", ".");
     }
     return $cha;
 }

 function consiste_pro() {
     $sta = 0;
     if (isset($_FILES['anexo']) == true) {
          $ret  = upload_ane($cam, $des, $tam, $ext, $men);
          if ($men != "") {
               echo '<script>alert("' . $men . '");</script>'; return 1;     
          }
     }
     if (trim($_REQUEST['des']) == "") {
          echo '<script>alert("Descrição do produto informado não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['uni']) == "") {
          echo '<script>alert("Unidade de Medida do produto informado não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['cli']) == "" || trim($_REQUEST['cli']) == 0) {
          echo '<script>alert("Cliente proprietário do produto informado não pode estar em branco");</script>';
          return 1;
     }
     return $sta;
}

function incluir_pro() {
     $ret = 0;
     include_once "dados.php";
     $pes = str_replace(".", "", $_REQUEST['pes']); $pes = str_replace(",", ".", $pes);
     $qtd = str_replace(".", "", $_REQUEST['qtd']); $qtd = str_replace(",", ".", $qtd);
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     $sql  = "insert into tb_produto (";
     $sql .= "proempresa, ";
     $sql .= "prostatus, ";
     $sql .= "prodescricao, ";
     $sql .= "prounidade, ";
     $sql .= "procodigo, ";
     $sql .= "progrupo, ";
     $sql .= "prolocal, ";
     $sql .= "propeso, ";
     $sql .= "proquantidade, ";
     $sql .= "propreco, ";
     $sql .= "procliente, ";
     $sql .= "prosuite, ";
     $sql .= "proobservacao, ";
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
     $sql .= "'" . ($qtd == "" ? 0 : $qtd) . "',";
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

 function alterar_pro() {
     $ret = 0;
     $pes = str_replace(".", "", $_REQUEST['pes']); $pes = str_replace(",", ".", $pes);
     $qtd = str_replace(".", "", $_REQUEST['qtd']); $qtd = str_replace(",", ".", $qtd);
     $pre = str_replace(".", "", $_REQUEST['pre']); $pre = str_replace(",", ".", $pre);
     include_once "dados.php";
     $sql  = "update tb_produto set ";
     $sql .= "prodescricao = '". $_REQUEST['des'] . "', ";
     $sql .= "prostatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "prounidade = '". $_REQUEST['uni'] . "', ";
     $sql .= "procodigo = '". $_REQUEST['key'] . "', ";
     $sql .= "progrupo = '". $_REQUEST['gru'] . "', ";
     $sql .= "prolocal = '". $_REQUEST['loc'] . "', ";
     $sql .= "propeso = '". $pes . "', ";
     $sql .= "proquantidade = '". $qtd . "', ";
     $sql .= "propreco = '". $pre . "', ";
     $sql .= "procliente = '". $_REQUEST['cli'] . "', ";
     $sql .= "prosuite = '". $_REQUEST['sui'] . "', ";
     $sql .= "proobservacao = '". str_replace("'", "´", $_REQUEST['obs']) . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idproduto = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 }   
     
 function excluir_pro() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_produto_a where aneproduto = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão dos anexos do produto !");</script>';
     }
     $sql  = "delete from tb_produto where idproduto = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro excluído no sistema com Sucesso !");</script>';
     } else {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }

 function upload_ane(&$cam, &$des, &$tam, &$ext, &$men) {
     $max = ini_get('upload_max_filesize');
     $sta = 0; $nro = 999; $men = "";
     $arq = isset($_FILES['anexo']) ? $_FILES['anexo'] : false;
     if ($arq == false) {
          return 2;
     }else if ($arq['name'][0] == "") {
          if ($_SESSION['wrkopereg'] == 1) {
               if ($arq['name'][0] != "") {
                    return 3;
               }
          }else{
               return 0;
          }
     }            
     $num = count($arq['name']);
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquuivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     for ($ind = 0;$ind < $num; $ind++) {
          $esp = $arq['size'][$ind];    // Está em bytes o campo original
          if ($arq['error'][$ind] != 0) {
               if ($_SESSION['wrkopereg'] >= 1) {
                    if ($arq['name'][$ind] != "") {
                         $men = $erro[$arq['error'][$ind]];
                         echo "<script>alert(" . $erro[$arq['error'][$ind]] . "')</script>";
                    }
                    $sta = 4; 
               }else{
                    return 0;
               }
          }
          if ($sta == 0) {
               $tip = array('jpg', 'jpeg', 'png', 'mp4', 'avi');
               $des = limpa_cpo($arq['name'][$ind]);
               $tam = $arq['size'][$ind];
               $lim = $tam / 1024;  // Byte - Kbyte - MegaByte
               $fim = explode('.', $des);
               $ext = end($fim);
               if (array_search($ext, $tip) === false) {
                    echo "<script>alert('Extensão do arquivo informado para Upload não é permitida')</script>";
                    $sta = 5; 
               }
          }
          if ($sta == 0) {
               $tip = explode('.', $des);
               $des = $tip[0] . "." . $ext;
               if ($nro == 999) {
                    $nro = ultima_cha($ane);
               } else {
                    $nro = $nro + 1;
               }
               $nom = "Ane_" . str_pad($_SESSION['wrkcodreg'], 9, "0", STR_PAD_LEFT) . "_" . str_pad($nro, 3, "0", STR_PAD_LEFT) . "." .  $ext;
               $pas = "anexos"; 
               if (file_exists($pas) == false) { mkdir($pas);  }

               $cam = $pas . "/" . $nom;
               $ret = move_uploaded_file($arq['tmp_name'][$ind], $cam);
               if ($ret == false) {
                    echo "<script>alert('Erro na cópia do arquivo (" . $ind . ") informado para upload')</script>";
                    $sta = 6; 
               }      
               $ret = incluir_ane($nro, $cam, $des, $tam, $lim, $nom, $ext);

          } 
     }   
     return $sta;
}

function ultima_cha(&$ane) {
     $qtd = 0; $ane = "";
     include_once "dados.php";
     $nro = quantidade_reg("Select idanexo, anesequencia, anedescricao from tb_produto_a where aneproduto = " . $_SESSION['wrkcodreg']  . " order by anesequencia desc Limit 1", $men, $lin);     
     if ($nro == 1 || $lin == true) {
          $ane = $lin['anedescricao'];
          $qtd = $lin['anesequencia'] + 1;
     }
     return $qtd;
}

function incluir_ane($nro, $cam, $des, $tam, $lim, $nom, $ext) {
     $ret = 0;
     include_once "dados.php";
     $sql  = "insert into tb_produto_a (";
     $sql .= "aneempresa, ";
     $sql .= "aneproduto, ";
     $sql .= "anestatus, ";
     $sql .= "anetipo, ";
     $sql .= "anesequencia, ";
     $sql .= "aneendereco, ";
     $sql .= "anedescricao, ";
     $sql .= "anecliente, ";
     $sql .= "anenome, ";
     $sql .= "anetamanho, ";
     $sql .= "aneextensao, ";
     $sql .= "aneobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
     $sql .= "'" . '0' . "',";
     $sql .= "'" . $_SESSION['wrkopereg'] . "',";
     $sql .= "'" . $nro . "',";
     $sql .= "'" . substr($cam, 0, 75) . "',";
     $sql .= "'" . substr($nom, 0, 75) . "',";
     $sql .= "'" . $_REQUEST['cli'] . "',";
     $sql .= "'" . substr($des, 0, 75) . "',";
     $sql .= "'" . round($lim,0 ) . "',";
     $sql .= "'" . $ext . "',";
     $sql .= "'" . 'Anexos importados de produtos ...' . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na gravação dos anexos de produto solicitado !");</script>';
     }
     return $ret;
}

function processa_mov() {
     $ret = 0;
     if ($_REQUEST['pes'] == "" || $_REQUEST['qtd'] == "" || $_REQUEST['pes'] == 0 || $_REQUEST['qtd'] == 0) {
          return 1;
     }     
     $ret = ler_movto($tra_e, $cha_m, $nro_m, $pes_m, $qtd_m); 
     $pes_p = str_replace(".", "", $_REQUEST['pes']); $pes_p = str_replace(",", ".", $pes_p);
     $qtd_p = str_replace(".", "", $_REQUEST['qtd']); $qtd_p = str_replace(",", ".", $qtd_p);
     $pre_p = str_replace(".", "", $_REQUEST['pre']); $pre_p = str_replace(",", ".", $pre_p);
     if ($nro_m == 0 && $tra_e >= 1) {
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
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
          $sql .= "'" . date('Y-m-d H:i:s') . "',";
          $sql .= "'" . $_REQUEST['cli'] . "',";
          $sql .= "'" . $tra_e . "',";
          $sql .= "'" . '0' . "',";
          $sql .= "'" . $_REQUEST['gru'] . "',";
          $sql .= "'" . $_REQUEST['loc'] . "',";
          $sql .= "'" . $_REQUEST['sui'] . "',";
          $sql .= "'" . $pes_p . "',";
          $sql .= "'" . $qtd_p . "',";
          $sql .= "'" . $pre_p . "',";
          $sql .= "'" . ($qtd_p * $pre_p) . "',";
          $sql .= "'" . $_SESSION['wrkdolant'] . "',";
          $sql .= "'" . $_SESSION['wrkdoldia'] . "',";
          $sql .= "'" . 'Movimento de entrada de quantidade em estoque do produto' . "',";
          $sql .= "'" . $_SESSION['wrkideusu'] . "',";
          $sql .= "'" . date("Y/m/d H:i:s") . "')";
          $ret = comando_tab($sql, $nro, $ult, $men);
          $_SESSION['wrkcodreg'] = $ult;
          if ($ret == false) {
               print_r($sql);
               echo '<script>alert("Erro na gravação do movimento solicitado !");</script>';
          }     
     } else if ($nro_m == 1 && $tra_e >= 1) {
          if ($qtd_m != ! $qtd_p || $pes_m != ! $pes_p) {
               $sql  = "update tb_movto set ";
               $sql .= "movpeso = '". $pes_p . "', ";
               $sql .= "movquantidade = '". $qtd_p . "', ";
               $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
               $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
               $sql .= "where idmovto = " . $cha_m;
               $ret = comando_tab($sql, $nro, $ult, $men);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na regravação do movimento solicitado !");</script>';
               }
          }
     }
     return $ret;
}

function ler_movto(&$tra, &$cha, &$nro, &$pes, &$qtd) {
     $ret = 0; $cha = 0; $qtd = 0; $nro = 0; $pes = 0; $tra = 0;
     include_once "dados.php";
     $com = "Select idmovto, movproduto, movtipo, movpeso, movquantidade from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movtipo = 0 and movproduto = " . $_SESSION['wrkcodreg'];
     $ret = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $cha = $lin['idmovto'];
          $pes = $lin['movpeso'];
          $qtd = $lin['movquantidade'];
          $nro = $nro + 1;
     }
     $com = "Select idgrupo from tb_grupo where gruempresa  = " . $_SESSION['wrkcodemp'] . " and grutiporeg = 3 and grutipogru = 1 order by idgrupo Limit 1";
     $ret = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $tra = $lin['idgrupo'];
     }
     return $ret;
}

?>

</html>