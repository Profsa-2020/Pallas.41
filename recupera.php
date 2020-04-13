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

<script>
$(document).ready(function() {

     $("#frmRecupera").submit(function() {
          var dad = $('#frmRecupera').serialize();
          $.post( "valida-ema.php", dad , function( data ) {
               console.log(data.ret);
               if (data.ret == 0) {
                    swal.fire("E-Mail Inválido", "E-Mail informado não cadastrado em nosso banco de dados", "error");
                    return false;
               }                
               if (data.ret == 1) {
                    return true;
               }                
               if (data.ret == 2) {
                    swal.fire("E-Mail Inválido", "E-Mail existe mais de uma vez em nosso banco de dados", "error");
                    return false;
               }                
          }, "json");
     });

});
</script>

<?php
$sta = 00; $ret = 00;
include_once "funcoes.php";
$_SESSION['wrknompro'] = __FILE__;
date_default_timezone_set("America/Sao_Paulo");
if (isset($_REQUEST['enviar']) == true) {
    $sta = verifica_usu($_REQUEST['email']);
    if ($sta == 2 || $ret == 2) {
        // echo '<script>alert("Existe mais de um usuário cadastrado com o mesmo e-mail !");</script>';
    }elseif ($sta != 1 && $ret != 1) {
        // echo '<script>alert("E-Mail informado não cadastrado em nosso banco de dados !");</script>';
    }else{
        if ($sta == 1) {
            $ret = enviar_usu($_REQUEST['email']);
        }
        echo "<script>history.go(-2);</script>";
    }
}

?>

<body class="login">
<h1 class="cab-0">Login Inicial Sistema MyLogBox - Controle de Estoques - Profsa Informática</h1>
     <div class="entrada">
          <div class="qua-1 animated bounceInDown">
               <form id="frmRecupera" name="frmRecupera" action="" method="POST">
                    <br /><br />
                    <div class="row">
                         <a href="http://www.mylogbox.com/">
                              <img src="img/logo-02.jpg" alt="Logotipo da empresa MyLogBox do Brasil"
                                   title="Recuperação de senha do sistema principal da empresa MyLogBox do Brasil" />
                         </a>
                    </div>
                    <br /><br />
                    <div class="row">
                         <div class="col s1"></div>
                         <div class="input-field col s10">
                              <i class="material-icons prefix">email</i>
                              <input type="text" class="text-center" id="email" name="email" maxlength="50" required>
                              <label for="nome">E-mail do usuário para envio ...</label>
                         </div>
                         <div class="col s1"></div>
                    </div>

                    <div class="row">
                         <input class="bot-1" type="submit" id="env" name="enviar" value="Enviar" />
                         <br /><br /><br />
                         <span class="tit-2"><a href="login.php">Voltar</a></span>
                    </div>
                    <br />
               </form>
          </div>
     </div>
</body>

<?php
        function verifica_usu($end) {
            include "lerinformacao.inc";
            $sql = mysqli_query($conexao,"Select idsenha from tb_usuario where usuemail = '$end'");
            if (mysqli_num_rows($sql) == 1) {
                return 1;
            }elseif (mysqli_num_rows($sql) >= 2) {
                return 2;
            }
            return 3;
        }

        function enviar_usu($end) {
            $sta = 0;
            include "lerinformacao.inc";
            $sql = mysqli_query($conexao,"Select * from tb_usuario where usuemail = '$end'");
            if (mysqli_num_rows($sql) > 0) {
                $linha = mysqli_fetch_array($sql);
                $nom = $linha['usunome'];
                $ema = $linha['usuemail'];
                $sen  = $linha['ususenha'];
                $pas = base64_decode($linha['ususenha']);

                $tex  = '<!DOCTYPE html>';
                $tex .= '<html lang="pt_br">';
                $tex .= '<head>';
                $tex .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                $tex .= '<title>MyLogBox do Brasil - Gerenciamento de Compras nos EUA</title>';
                $tex .= '</head>';
                $tex .= '<body>';
                $tex .= '<a href="http://www.mylogbox.com/login.php">';
                $tex .= '<p align="center">';
                $tex .= '<img border="0" src="http://www.mylogbox.com/img/logo-02.jpg"></p></a>';
                $tex .= '<p align="center">&nbsp;</p>';
                $tex .= '<p align="center"><font size="5" face="Verdana" color="#FF0000"><b>Recuperação de Senha de Usuário</b></font></p>';
                $tex .= '<p align="center">&nbsp;</p>';
                $tex .= '<p align="center"><font size="5" face="Verdana"><b>Nome: ' . $nom . '</b></font></p>';
                $tex .= '<p align="center"><font size="5" face="Verdana"><b>Login: ' . $ema . '</b></font></p>';
                $tex .= '<p align="center"><font size="5" face="Verdana"><b>Senha: ' . $pas . '</b></font></p>';
                $tex .= '<p align="center"><font size="4" face="Verdana"><a href="http://www.mylogbox.com/login.php">';
                $tex .= 'www.mylogbox.com</a></font></p>';
                $tex .= '<p align="center">&nbsp;</p>';

                $tex .= '</body>';
                $tex .= '</html>';

                $asu = "Recuperação de login e senha do sistema MyLogBox do Brasil";

                $sta = envia_email($ema, $asu, $tex, $nom, '', '');

                if ($sta == 1) {
                    echo '<script>alert("Senha e Login de acesso enviado com sucesso !");</script>';
                    $ret = gravar_log(16,"Solicitação de reenvio de acesso para " . $nom . " - E-Mail: " . $ema);
                }else{
                    echo '<script>alert("Erro no envio de login e senha para o usuário !");</script>';
                }
            }
            return $sta;
        }

        ?>


</html>