<?php
     $pro = 0;
     $pre = '';
     session_start();
     $dad = array();     
     $dad['men'] = '';
     $dad['pre'] = '';
     if (isset($_REQUEST['pro']) == true) { $pro = $_REQUEST['pro']; }
     if (isset($_REQUEST['pre']) == true) { $pre = $_REQUEST['pre']; }
     include_once "dados.php";    
     include_once "funcoes.php";    
     $nro = quantidade_reg("Select idproduto, propreco, propeso from tb_produto where idproduto = " . $pro, $men, $reg);     
     if ($nro == 1 || $reg == true) {
          $dad['pes'] = number_format($reg['propeso'], 4, ",", ".");
          if ($pre == "") {
               $dad['pre'] = number_format($reg['propreco'], 2, ",", ".");
          }
     }
     echo json_encode($dad);
?>