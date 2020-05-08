<?php
     $pro = 0;
     $pre = 0;
     $qtd = 0;
     $pes = 0;
     session_start();
     $dad = array();     
     $dad['men'] = '';
     $dad['pes'] = '';
     if (isset($_REQUEST['pro']) == true) { $pro = $_REQUEST['pro']; }
     if (isset($_REQUEST['pre']) == true) { $pre = $_REQUEST['pre']; }
     if (isset($_REQUEST['pes']) == true) { $pes = $_REQUEST['pes']; }
     if (isset($_REQUEST['qtd']) == true) { $qtd = $_REQUEST['qtd']; }
     include_once "dados.php";    
     include_once "funcoes.php";    
     $nro = quantidade_reg("Select idproduto, propreco, propeso, proquantidade from tb_produto where idproduto = " . $pro, $men, $reg);     
     if ($nro == 1 || $reg == true) {
          if ($reg['propeso'] > 0 && $reg['proquantidade'] > 0){
               $dad['pes'] = number_format($reg['propeso'] / $reg['proquantidade'] * $qtd, 4, ",", ".");
          }
     }
     echo json_encode($dad);
?>