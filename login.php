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
     <title>MyLogBox - Controle de Estoques de compras de clientes no EUA - Login</title>
</head>

<?php
     $ret = 0;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkmostel'] = 0; $_SESSION['wrkopereg'] = 0; $_SESSION['wrkcodreg'] = 0;
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $sen = (isset($_REQUEST['sen']) == false ? '' : $_REQUEST['sen']);
     $lem = (isset($_REQUEST['lem']) == false ? '' : $_REQUEST['lem']);
     $ret = verifica_ace($ret); 
     if (isset($_POST['entrar']))  {

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
                              <img src="img/logo-05.jpg" alt="Logotipo da empresa MyLogBox"
                                   title="Acesso ao site principal da empresa MyLogBox" />
                         </a>
                    </div>
                    <br /><br />
                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">
                              <i class="material-icons prefix">email</i>
                              <input type="text" class="text-center" id="email" name="email" maxlength="50" required>
                              <label for="nome">E-mail do usuário para acesso ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>

                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">
                              <i class="material-icons prefix">lock</i>
                              <input type="password" class="text-center" id="senha" name="senha" maxlength="15"
                                   required>
                              <label for="senha">Senha de acesso ao sistema ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>

                    <div class="row">
                         <input class="bot-1" type="submit" name="entrar" value="Entrar" />
                         <br /><br />
                         <input type="checkbox" id="lem" name="lem" value="S" />
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
function verifica_ace($ret) {
     $ret = 0;
     if (isset($_COOKIE["k_ent"]) == false || isset($_COOKIE["k_end"]) == false) {
          return 9;
     }
     $sen_usu = $_COOKIE["k_ent"];
     $ema_usu = $_COOKIE["k_end"];
     $sta = val_entrada($sen_usu, $ema_usu);
     if ($sta == 0) {
          if ($_SESSION['wrkstausu'] == 2) {
               $sta = 2;
          }
          if ($sta == 0) {
               if ($_SESSION['wrktipusu'] == 1) {
                    $ret = gravar_log(1,"Entrada para acesso ao sistema Pallas.33 - Menu.01 - MyLogBox Brasil");  
                    exit('<script>location.href = "menu00.php"</script>');
               }else if ($_SESSION['wrktipusu'] == 2) {
                    $ret = gravar_log(2,"Entrada para acesso ao sistema Pallas.33 - Menu.02 - MyLogBox Brasil");  
                    exit('<script>location.href = "menu00.php"</script>');
               }else if ($_SESSION['wrktipusu'] == 3) {
                    $ret = gravar_log(3,"Entrada para acesso ao sistema Pallas.33 - Menu.03 - MyLogBox Brasil");  
                    exit('<script>location.href = "menu03.php"</script>');
               }else if ($_SESSION['wrktipusu'] == 4) {
                    $ret = gravar_log(4,"Entrada para acesso ao sistema Pallas.33 - Menu.04 - MyLogBox Brasil");  
                    exit('<script>location.href = "menu00.php"</script>');
               }else if ($_SESSION['wrktipusu'] >= 5) {
                    $ret = gravar_log(5,"Entrada para acesso ao sistema Pallas.33 - Menu.05 - MyLogBox Brasil");  
                    exit('<script>location.href = "menu00.php"</script>');
               }
          }
     }
     return $ret;
}

?>
