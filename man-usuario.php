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

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Usuários</title>
</head>

<script>
$(function() {
     $("#ace").mask("000.000");
     $("#val").mask("00/00/0000");
     $("#val").datepicker($.datepicker.regional["pt-BR"]);
});

$(document).ready(function() {

});

</script>

<?php
     $ret = 00;
     $per = "";
     $bot = "Salvar";
     include_once "dados.php";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     if ( $_SESSION['wrktipusu'] <= 3) {
          echo '<script>alert("Nível de usuário não permite acesso a essa opção");</script>';
          echo '<script>history.go(-1);</script>';
     }

     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6,"Entrada na página de manutenção de usuários do sistema Pallas.41 - MyLogBox do Brasil");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0  : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0  : $_REQUEST['sta']);
     $tip = (isset($_REQUEST['tip']) == false ? 0  : $_REQUEST['tip']);
     $sen = (isset($_REQUEST['sen']) == false ? '' : $_REQUEST['sen']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $val = (isset($_REQUEST['val']) == false ? '' : $_REQUEST['val']);
     $ace = (isset($_REQUEST['ace']) == false ? 0 : $_REQUEST['ace']);
     $nom = (isset($_REQUEST['nom']) == false ? '' : str_replace("'", "´", $_REQUEST['nom']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
    }
    if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de usuário informado em tela ?\')" ';
    }  
    if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
              $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
              $ret = ler_usuario($cha, $nom, $sta, $tip, $sen, $ema, $val, $ace); 
          }
      }
      if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
              $ret = consiste_usu();
              if ($ret == 0) {
                  $ret = incluir_usu();
                  $ret = enviar_ema($_REQUEST['ema']);
                  $ret = gravar_log(11,"Inclusão de novo usuário: " . $nom);
                  $sen = ''; $nom = ''; $ema = ''; $sta = ''; $tip = ''; $val = ''; $ace = ''; 
              }
          }
          if ($_SESSION['wrkopereg'] == 2) {
              $ret = consiste_usu();
              if ($ret == 0) {
                  $ret = alterar_usu();
                  $ret = enviar_ema($_REQUEST['ema']);
                  $ret = gravar_log(12,"Alteração de usuário existente: " . $nom); $_SESSION['wrkmostel'] = 0;
                  $sen = ''; $nom = ''; $ema = ''; $sta = ''; $tip = ''; $val = ''; $ace = ''; 
                  echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
              }
          }
          if ($_SESSION['wrkopereg'] == 3) {
              $ret = excluir_usu();
              $ret = gravar_log(13,"Exclusão de usuário existente: " . $nom); $_SESSION['wrkmostel'] = 0;
              $sen = ''; $nom = ''; $ema = ''; $sta = ''; $tip = ''; $val = ''; $ace = ''; 
              echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
      }
?>

<body>
     <h1 class="cab-0">MyLogBox - Manutenção Usuários  - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <div class="row qua-2">
                    <div class="col-md-11 text-left">
                         <span>Manutenção de Usuários</span>
                    </div>
                    <div class="col-md-1">
                         <form name="frmTelNov" action="man-usuario.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Mostra campos para criar novo usuario no sistema"><i
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
                         <div class="col-md-10">
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-10">
                              <label>Nome do Usuário</label>
                              <input type="text" class="form-control" maxlength="50" id="nom" name="nom"
                                   value="<?php echo $nom; ?>" required />
                         </div>
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
                         <div class="col-md-2">
                              <label>Senha</label>
                              <input type="password" class="form-control" maxlength="15" id="sen" name="sen"
                                   value="<?php echo $sen; ?>" required />
                         </div>
                         <div class="col-md-8">
                              <label>E-Mail</label>
                              <input type="email" class="form-control" maxlength="50" id="ema" name="ema"
                                   value="<?php echo $ema; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Tipo</label>
                              <select name="tip" class="form-control" required>
                                   <option value="0" <?php echo ($tip != 0 ? '' : 'selected="selected"'); ?>>
                                        Visitante</option>
                                   <option value="1" <?php echo ($tip != 1 ? '' : 'selected="selected"'); ?>>
                                        Cliente</option>
                                   <option value="2" <?php echo ($tip != 2 ? '' : 'selected="selected"'); ?>>
                                        Colaborador</option>
                                   <option value="3" <?php echo ($tip != 3 ? '' : 'selected="selected"'); ?>>
                                        Chefe</option>
                                   <option value="4" <?php echo ($tip != 4 ? '' : 'selected="selected"'); ?>>
                                        Supervisor</option>
                                   <option value="5" <?php echo ($tip != 5 ? '' : 'selected="selected"'); ?>>
                                        Gerência</option>
                                   <option value="6" <?php echo ($tip != 6 ? '' : 'selected="selected"'); ?>>
                                        Diretor</option>
                                   <option value="7" <?php echo ($tip != 7 ? '' : 'selected="selected"'); ?>>
                                        Presidência</option>
                              </select>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-3">
                              <label>Acessos</label>
                              <input type="text" class="form-control text-center" maxlength="6" id="ace" name="ace"
                                   value="<?php echo $ace; ?>" />
                         </div>
                         <div class="col-md-6"></div>
                         <div class="col-md-3">
                              <label>Validade</label>
                              <input type="text" class="form-control text-center" maxlength="10" id="val" name="val"
                                   value="<?php echo $val; ?>" />
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
                    <div class="form-row">
                         <div class="col-md-12 text-center">
                              <?php
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                   ?>
                         </div>
                    </div>
                    <br />
               </form>
          </div>
</body>

<?php
function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = quantidade_reg('Select idsenha, usunome from tb_usuario order by idsenha desc Limit 1', $men, $reg);     
     if ($nro == 1) {
          $cod = $reg['idsenha'] + 1;
     }
     return $cod;
 }

 function ler_usuario(&$cha, &$nom, &$sta, &$tip, &$sen, &$ema, &$val, &$ace) {
     include_once "dados.php";
     $nro = quantidade_reg("Select * from tb_usuario where idsenha = " . $cha, $men, $reg);     
     if ($nro == 0 || $reg == false) {
          echo '<script>alert("Código do usuário informada não cadastrada");</script>';
          $nro = 1;
     } else {
          $cha = $reg['idsenha'];
          $nom = $reg['usunome'];
          $sta = $reg['usustatus'];
          $tip = $reg['usutipo'];
          $ace = $reg['usuacessos'];
          $sen = base64_decode($reg['ususenha']);
          $ema = $reg['usuemail'];
          if ($reg['usuvalidade'] != null) { 
               $val = date('d/m/Y',strtotime($reg['usuvalidade'])); 
          }        
     }
     return $cha;
 }

 function consiste_usu() {
     $sta = 0;
     if (trim($_REQUEST['nom']) == "") {
         echo '<script>alert("Nome do Usuário não pode estar em branco");</script>';
         return 1;
     }
     if (trim($_REQUEST['sen']) == "") {
         echo '<script>alert("Senha do Usuário não pode estar em branco");</script>';
         return 2;
     }
     if (trim($_REQUEST['ema']) == "") {
         echo '<script>alert("E-mail do Usuário não pode estar em branco");</script>';
         return 3;
     }
     if ($_REQUEST['val'] != "") {
          if (valida_dat($_REQUEST['val']) != 0) {
               echo '<script>alert("Data de validade informada no usuário não é valida");</script>';
               return 4;
          }
     }
     if($_REQUEST['tip'] > $_SESSION['wrktipusu'] ) {
          echo '<script>alert("Usuário não pode informar nivel de acesso maior que o seu");</script>';
          return 5;
     }
     include_once "dados.php";     
     $nro = carrega_tab("Select idsenha from tb_usuario where usuemail = '" . $_REQUEST['ema'] . "'" , $reg);
     if ($nro > 0) {
          if ($reg[0]['idsenha'] != 0 && $reg[0]['idsenha'] != $_SESSION['wrkcodreg']) {
               echo '<script>alert("E-mail informado para usuário já existe cadastrado");</script>';
               return 6;
          }
     }
     return $sta;
 }    
     
 function incluir_usu() {
     $ret = 0;
     include_once "dados.php";
     $ace = str_replace(".", "", $_REQUEST['ace']); $ace = str_replace(",", ".", $ace);
     $val = substr($_REQUEST['val'],6,4) . "-" . substr($_REQUEST['val'],3,2) . "-" . substr($_REQUEST['val'],0,2);     
     $sql  = "insert into tb_usuario (";
     $sql .= "usustatus, ";
     $sql .= "usunome, ";
     $sql .= "usuemail, ";
     $sql .= "ususenha, ";
     $sql .= "usutipo, ";
     $sql .= "usuacessos, ";
     $sql .= "usuvalidade, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['nom'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . base64_encode($_REQUEST['sen']) . "',";
     $sql .= "'" . $_REQUEST['tip'] . "',";
     $sql .= "'" . ($ace == "" ? '0' : $ace) . "',";
     $sql .= "'" . ($val == "--" ? date('Y-m-d', strtotime('+180 days')) : $val) . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro incluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
 }

function alterar_usu() {
     $ret = 0;
     include_once "dados.php";
     $ace = str_replace(".", "", $_REQUEST['ace']); $ace = str_replace(",", ".", $ace);
     $val = substr($_REQUEST['val'],6,4) . "-" . substr($_REQUEST['val'],3,2) . "-" . substr($_REQUEST['val'],0,2);
     $sql  = "update tb_usuario set ";
     $sql .= "usunome = '". $_REQUEST['nom'] . "', ";
     $sql .= "usustatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "usutipo = '". $_REQUEST['tip'] . "', ";
     $sql .= "ususenha = '". base64_encode($_REQUEST['sen']) . "', ";
     $sql .= "usuemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "usuacessos = '". ($ace == "" ? '0' : $ace) . "', ";
     $sql .= "usuvalidade =  ". ($val == "--" ? 'null' : "'" . $val . "'") . " , ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idsenha = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 }   
     
 function excluir_usu() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_usuario where idsenha = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == true) {
          echo '<script>alert("Registro excluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }

 function enviar_ema($ema_usu) {
     $sta = 0;
     include_once "dados.php";
     $nro = quantidade_reg("Select * from tb_usuario where usuemail = '" . $ema_usu . "'", $men, $reg);     
     if ($nro == 1 || $reg == true) {
         $sen = base64_decode($reg['ususenha']);
         $nom = $reg['usunome'];
         $ema = $reg['usuemail'];
 
         $tex  = '<!DOCTYPE html>';
         $tex .= '<html lang="pt_br">';
         $tex .= '<head>';
         $tex .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
         $tex .= '<title>MyLogBox do Brasil - Controle de Estoques</title>';
         $tex .= '</head>';
         $tex .= '<body>';
         $tex .= '<p align="center">';
         $tex .= '<img border="0" src="http://www.mylogbox.com/pallas41/img/logo-05.jpg"></p>';
         $tex .= '<p align="center">&nbsp;</p>';
         $tex .= '<p align="center"><font size="5" face="Verdana" color="#FF0000"><b>Cadastramento de Acesso</b></font></p>';
         $tex .= '<p align="center">&nbsp;</p>';
         $tex .= '<p align="center"><font size="5" face="Verdana"><b>Nome: ' . $nom . '</b></font></p>';
         $tex .= '<p align="center"><font size="5" face="Verdana"><b>Login: ' . $ema . '</b></font></p>';
         $tex .= '<p align="center"><font size="5" face="Verdana"><b>Senha: ' . $sen . '</b></font></p>';
         $tex .= '<p align="center"><font size="4" face="Verdana"><a href="http://www.mylogbox.com/pallas41/login.php">';
         $tex .= 'www.mylogbox.com</a></font></p>';
         $tex .= '<p align="center">&nbsp;</p>';
 
         $tex .= '</body>';
         $tex .= '</html>';
 
         $asu = "Acesso ao sistema MyLogBox - Controle de Estoques";
 
         $sta = envia_email($ema, $asu, $tex, $nom, '', '');
 
         if ($sta != 1) {
             echo '<script>alert("Erro no envio de login e senha para o usuário !");</script>';
         }
     }
     return $sta;
 }

?>

</html>