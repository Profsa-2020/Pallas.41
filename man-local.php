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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas41.css" rel="stylesheet" type="text/css" media="screen" />
     <title>MyLogBox - Controle de Estoques de compras de clientes nos EUA - Locais</title>
</head>

<script>
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
     $bot = "Salvar";
     include_once "dados.php";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     if ( $_SESSION['wrktipusu'] <= 3) {
          echo '<script>alert("Nível de usuário não permite acesso a essa opção");</script>';
          echo '<script>history.go(-1);</script>';
     }
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(6,"Entrada na página de manutenção de locais de produtos do sistema Pallas.41 - MyLogBox");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 00 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 00 : $_REQUEST['sta']);
     $tip = (isset($_REQUEST['tip']) == false ? 00 : $_REQUEST['tip']);
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
     }
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; 
               $ret = ler_local($cha, $des, $sta); 
          }
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de local do produto informado em tela ?\')" ';
     }

 if (isset($_REQUEST['salvar']) == true) {
      if ($_SESSION['wrkopereg'] == 1) {
           $sta = consiste_loc();
           if ($sta == 0) {
                $ret = incluir_loc();
                $cod = ultimo_cod();
                $ret = gravar_log(11,"Inclusão de novo local do produto: " . $des); 
                $des = ''; $sta = 00;  $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
      if ($_SESSION['wrkopereg'] == 2) {
           $sta = consiste_loc();
           if ($sta == 0) {
                $ret = alterar_loc();
                $cod = ultimo_cod(); 
                $ret = gravar_log(12,"Alteração de local do produto cadastrado: " . $des); 
                $des = ''; $sta = 00;  $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
           }
      }
      if ($_SESSION['wrkopereg'] == 3) {
           $ret = excluir_loc(); $bot = 'Salvar'; $per = '';
           $cod = ultimo_cod(); 
           $ret = gravar_log(13,"Exclusão de local do produto cadastrado: " . $des); 
           $des = ''; $sta = 00;  $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = 0;
      }
}
?>

<body id="box00">
<h1 class="cab-0">MyLogBox - Manutenção Locais - Controle de Estoques - Profsa Informática</h1>
     <div class="row">
          <div class="col-md-12">
               <?php include_once "cabecalho-1.php"; ?>
          </div>
     </div>
     <div class="container">
          <div class="qua-0">
               <div class="row qua-2">
                    <div class="col-md-11 text-left">
                         <span>Manutenção de Local do Produto</span>
                    </div>
                    <div class="col-md-1 text-center">
                         <form name="frmTelNov" action="man-local.php?ope=1&cod=0" method="POST">
                              <div class="text-center">
                                   <button type="submit" class="bot-2" id="nov" name="novo"
                                        title="Mostra campos para criar novo local do produto no sistema"><i
                                             class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                              </div>
                         </form>
                    </div>
               </div>
               <form class="tel-1" name="frmTelMan" action="" method="POST">
                    <div class="form-row">
                         <div class="col-md-2">
                              <label>Número</label>
                              <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                   value="<?php echo $cod; ?>" disabled />
                         </div>
                         <div class="col-md-8">
                              <label>Descrição do Local de Produto</label>
                              <input type="text" class="form-control" maxlength="50" id="des" name="des"
                                   value="<?php echo $des; ?>" required />
                         </div>
                         <div class="col-md-2">
                              <label>Status</label><br />
                              <select name="sta" class="form-control">
                                   <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                        Normal
                                   </option>
                                   <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                        Bloqueado
                                   </option>
                                   <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                        Suspenso
                                   </option>
                                   <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                        Cancelado
                                   </option>
                              </select>
                         </div>
                    </div>
                    <br />
                    <div class="form-row text-center">
                         <div class="col-md-6"></div>
                         <div class="col-md-6 text-right">
                              <button type="submit" name="salvar" <?php echo $per; ?>
                                   class="bot-1"><?php echo $bot; ?></button>
                         </div>
                    </div>
                    <br />
               </form>
               <div class="col-md-12 text-center">
                    <br />
                    <div class="tab-1 table-responsive">
                         <table class="table table-sm table-striped">
                              <thead>
                                   <tr>
                                        <th scope="col">Alterar</th>
                                        <th scope="col">Excluir</th>
                                        <th scope="col">Número</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Descrição do Local do Produto</th>
                                        <th scope="col">Inclusão</th>
                                        <th scope="col">Alteração</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php $ret = carrega_loc();  ?>
                              </tbody>
                         </table>
                    </div>
                    <br />
               </div>
          </div>
          <div id="box10">
               <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
          </div>
     </div>
</body>

<?php
if ($_SESSION['wrkopereg'] == 1 && $_SESSION['wrkcodreg'] == $cod) {
     exit('<script>location.href = "man-local.php?ope=1&cod=0"</script>');
}

function ultimo_cod() {
     $cod = 1;
     include_once "dados.php";
     $nro = quantidade_reg('Select idgrupo from tb_grupo order by idgrupo desc Limit 1', $men, $reg);     
     if ($nro == 1) {
          $cod = $reg['idgrupo'] + 1;
     }        
     return $cod;
}

function consiste_loc() {
     $sta = 0;
     if (trim($_REQUEST['des']) == "") {
          echo '<script>alert("Descrição do local do produto não pode estar em branco");</script>';
          return 1;
     }
     return $sta;
 }

function carrega_loc() {
     include_once "dados.php";
     $com = "Select * from tb_grupo where gruempresa  = " . $_SESSION['wrkcodemp'] . " and grutiporeg = 2 order by grudescricao, idgrupo";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $txt =  '<tr>';
          $txt .= '<td class="bot-3 text-center"><a href="man-local.php?ope=2&cod=' . $lin['idgrupo'] . '" title="Efetua alteração do registro informado na linha"><i class="bot-1a large material-icons">healing</i></a></td>';
          $txt .= '<td class="lit-d bot-3 text-center"><a href="man-local.php?ope=3&cod=' . $lin['idgrupo'] . '" title="Efetua exclusão do registro informado na linha"><i class="bot-1e large material-icons">delete_forever</i></a></td>';
          $txt .= '<td class="text-center">' . $lin['idgrupo'] . '</td>';
          if ($lin['grustatus'] == 0) {$txt .= "<td>" . "Normal" . "</td>";}
          if ($lin['grustatus'] == 1) {$txt .= "<td>" . "Bloqueado" . "</td>";}
          if ($lin['grustatus'] == 2) {$txt .= "<td>" . "Suspenso" . "</td>";}
          if ($lin['grustatus'] == 3) {$txt .= "<td>" . "Cancelado" . "</td>";}
          $txt .= '<td class="text-left">' . $lin['grudescricao'] . "</td>";
          if ($lin['datinc'] == null) {
               $txt .= "<td>" . '' . "</td>";
          }else{
               $txt .= "<td>" . date('d/m/Y H:m:s',strtotime($lin['datinc'])) . "</td>";
          }
          if ($lin['datalt'] == null) {
               $txt .= "<td>" . '' . "</td>";
          }else{
               $txt .= "<td>" . date('d/m/Y H:m:s',strtotime($lin['datalt'])) . "</td>";
          }
          $txt .= "</tr>";
         echo $txt;
     }
}

function incluir_loc() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "insert into tb_grupo (";
     $sql .= "gruempresa, ";
     $sql .= "grustatus, ";
     $sql .= "grutipogru, ";
     $sql .= "grutiporeg, ";
     $sql .= "grudescricao, ";
     $sql .= "gruobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . '2' . "',";
     $sql .= "'" . '2' . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['des']) . "',";
     $sql .= "'" . '' . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     return $ret;
}

function ler_local(&$cha, &$des, &$sta) {
     include_once "dados.php";
     $sql = "Select * from tb_grupo where idgrupo = " . $cha;
     $nro = carrega_reg($sql, $lin);
     if ($nro == 0) {
          echo '<script>alert("Código do local informado não cadastrada no sistema");</script>';
     } else {
          $cha = $lin['idgrupo'];
          $des = $lin['grudescricao'];
          $sta = $lin['grustatus'];
     }
     return $cha;
 }

 function alterar_loc() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "update tb_grupo set ";
     $sql .= "grustatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "grudescricao = '". $_REQUEST['des'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idgrupo = " . $_SESSION['wrkcodreg'];
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     return $ret;
 } 

 function excluir_loc() {
     $ret = 0;
     include_once "dados.php";
     $sql  = "delete from tb_grupo where idgrupo = " . $_SESSION['wrkcodreg'] ;
     $ret = comando_tab($sql, $nro, $ult, $men);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     return $ret;
 }


?>

</html>
