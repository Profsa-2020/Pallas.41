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

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@8/dist/sweetalert2.min.css" id="theme-styles">

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Login</title>
</head>

<?php
     include_once "funcoes.php";
     $ret = 0; $err_n = 0; $err_d = '';
     $_SESSION['wrktipban'] = "mysql";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkmostel'] = 0; $_SESSION['wrkopereg'] = 0; $_SESSION['wrkcodreg'] = 0;
     $ema = (isset($_REQUEST['email']) == false ? '' : $_REQUEST['email']);
     $sen = (isset($_REQUEST['senha']) == false ? '' : $_REQUEST['senha']);
     $lem = (isset($_REQUEST['lembrete']) == false ? 0 : $_REQUEST['lembrete']);
     $ret = verifica_ace($ret); 
     if (isset($_POST['entrar']))  {
          $nro = valida_ent($sen, $ema);
          if (trim($ema) == "") {
               $err_n = 1; $err_d = 'E-mail para efetuar Login no sistema não pode estar em branco !';
          } else if (trim($sen) == "") {
               $err_n = 2; $err_d = 'Senha para efetuar Login no sistema não pode estar em branco !';
          } else if ($nro >= 1) {
               $err_n = 3; $err_d = 'Existem caracteres inválidos informado no Login e/ou Senha !';
          } else {
               include_once "dados.php";
               $ret = usuario_log(2, $ema, $sen, $reg);
               if ($ret > 1) {
                    $err_n = 3; $err_d = 'Existe mais de um usuário com o mesmo login e senha cadastrado !';
               } else if($ret == 0) {
                    $err_n = 4; $err_d = 'Login e/ou Senha informado, não cadastrado no banco de dados !';
               } else if ($ret == 1) {
                    if ($reg['usustatus'] > 0) {
                         $err_n = 5; $err_d = 'Status do Usuário não tem permissão de acesso ao sistema !';
                    } else if ($reg['usutipo'] <= 3) { // 0-visitante, 1-cliente, 2-colaborador, 3-chefe, 4-supervisor, 5-diretor, 6-presidente
                              $err_n = 6; $err_d = 'Tipo de usuário informado para login não tem acesso ao sistema !';
                    } else if ($reg['usuacessos'] != null) {
                         if ($reg['usuacessos'] <= 1) {
                              $err_n = 7; $err_d = 'Número de acessos do usuário ao sistema está finalizado !';
                         } elseif ($reg['usuacessos'] <= 30) {
                              echo '<script>alert("Atenção ! Usuário terá somente mais ' . $reg['usuacessos'] . ' acessos ao sistema !");</script>';     
                         }
                    } 
                    if ($reg['usuvalidade'] != null) {
                         $dia = diferenca_dat('', $reg['usuvalidade']);
                         if ($reg['usuvalidade'] < date('Y-m-d')) {
                              $err_n = 8; $err_d = 'Data de validade do usuário para acesso ao sistema está vencida !';
                         } elseif (abs($dia) <= 15) {
                              echo '<script>alert("Atenção ! Usuário terá somente mais ' . abs($dia) . ' dias de acesso ao sistema !");</script>';     
                         }
                    }
                    if ($err_n == 0) {
                         $_SESSION['wrkideusu'] = $reg['idsenha']; 
                         $_SESSION['wrknomusu'] = $reg['usunome'];
                         $_SESSION['wrktipusu'] = $reg['usutipo'];
                         $_SESSION['wrkemausu'] = $reg['usuemail'];
                         $_SESSION['wrkstausu'] = $reg['usustatus'];
                         $_SESSION['wrkcodemp'] = $reg['usuempresa'];
                         $_SESSION['wrkdatval'] = $reg['usuvalidade'];
                         $_SESSION['wrknumace'] = $reg['usuacessos'];                 
                         if ($_SESSION['wrknumace'] >= 2) {
                              $com = "Update tb_usuario set usuacessos = " . ($_SESSION['wrknumace'] - 1) . " where idsenha = " . $_SESSION['wrkideusu'];
                              $ret = comando_tab($com, $nro, $ult, $men); 
                         }
                         $ret = gravar_log(5,"Entrada para acesso ao sistema Pallas.41 - Menu.01 - MyLogBox do Brasil");  
                         exit('<script>location.href = "menu01.php"</script>');
                    }
               }
          }
     }
?>

<body class="login">
     <h1 class="cab-0">Login Inicial Sistema MyLogBox - Controle de Estoques - Profsa Informática</h1>
     <div class="entrada">
          <div class="qua-1 animated bounceInDown">
               <form name="frmLogin" action="" method="POST">
                    <br /><br />
                    <div class="row">
                         <a href="http://www.mylogbox.com/">
                              <img class="img-fluid" src="img/logo-05.jpg" alt="Logotipo da empresa MyLogBox"
                                   title="Acesso ao site principal da empresa MyLogBox" />
                         </a>
                    </div>
                    <br /><br />
                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">
                              <i class="material-icons prefix">email</i>
                              <input type="email" class="text-center" id="ema" name="email" maxlength="50" required >
                              <label for="nome">E-mail do usuário para acesso ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>

                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">
                              <i class="material-icons prefix">lock</i>
                              <input type="password" class="text-center" id="sen" name="senha" maxlength="15" required >
                              <label for="senha">Senha de acesso ao sistema ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>

                    <div class="row">
                         <input class="bot-1" type="submit" id="ent" name="entrar" value="Entrar" />
                         <br /><br />
                         <input type="checkbox" id="lem" name="lembrete" value="S" />
                         <label class="tit-1" for="lem">Lembrar Login</label>
                         <br />
                         <span class="tit-2"><a href="recupera.php">Esqueci a senha</a></span>
                    </div>
                    <br />
               </form>
          </div>
     </div>
</body>

<?php

if ($err_n > 0) {
     echo '<script>alert("' . $err_d . '");</script>';
}

function verifica_ace($ret) {
     $ret = 0;
     if (isset($_COOKIE["k_ent"]) == false || isset($_COOKIE["k_end"]) == false) {
          return 9;
     }
     $sen = $_COOKIE["k_ent"];
     $ema = $_COOKIE["k_end"];

     return $ret;
}

?>
