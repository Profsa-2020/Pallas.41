<?php
     $cli = 0;
     $tip = 0;
     $sui = '';
     session_start();
     $dad = array();     
     $dad['men'] = '';
     $dad['sui'] = '';
     $dad['cli'] = 0;
     $dad['tip'] = 0;
     if (isset($_REQUEST['tip']) == true) { $tip = $_REQUEST['tip']; }
     if (isset($_REQUEST['cli']) == true) { $cli = $_REQUEST['cli']; }
     if (isset($_REQUEST['sui']) == true) { $sui = $_REQUEST['sui']; }
     include_once "dados.php";    
     include_once "funcoes.php";    
     if ($tip == 0) {
          $nro = quantidade_reg("Select idcliente, clisuite from tb_cliente where clisuite = '" . $sui . "'", $men, $reg);     
     } else {
          $nro = quantidade_reg("Select idcliente, clisuite from tb_cliente where idcliente = " . $cli, $men, $reg);     
     }
     if ($nro == 1 || $reg == true) {
          if ($_SESSION['wrkopereg'] == 1) {
               if ($tip == 0) {
                    $dad['cli'] = $reg['idcliente'];
               } else {
                    $dad['sui'] = $reg['clisuite'];
               }
          } else if ($tip == 1) {
               $dad['sui'] = $reg['clisuite'];
          } else if ($tip == 0) {
               $dad['cli'] = $reg['idcliente'];
          }
     }
     echo json_encode($dad);
?>