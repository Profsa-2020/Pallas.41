<?php
     $tip = 9;
     $tra = 0;
     $pro = 0;
     $qtd = 0;
     $pes = 0;
     $pre = 0;
     $est = 0;
     $atu = 0;
     session_start();
     $dad = array();     
     $dad['men'] = '';
     $dad['txt'] = '';
     $dad['tip'] = 0;
     if (isset($_REQUEST['tra']) == true) { $tra = $_REQUEST['tra']; }
     if (isset($_REQUEST['pro']) == true) { $pro = $_REQUEST['pro']; }
     if (isset($_REQUEST['qtd']) == true) { $qtd = $_REQUEST['qtd']; }
     if (isset($_REQUEST['pes']) == true) { $pes = $_REQUEST['pes']; }
     if (isset($_REQUEST['pre']) == true) { $pre = $_REQUEST['pre']; }
     include_once "dados.php";    
     include_once "funcoes.php";    

     $nro = quantidade_reg("Select idgrupo, grutipogru from tb_grupo where idgrupo = '" . $tra . "'", $men, $reg);     
     if ($nro == 1 || $reg == true) {
          $tip = $reg['grutipogru'];
     }
     if ($tip != 9) {
          $nro = quantidade_reg("Select idproduto, proestoqueqtd, proestoquepes from tb_produto where idproduto = '" . $pro . "'", $men, $reg);     
          if ($nro == 1 || $reg == true) {
               $est = $reg['proestoqueqtd'];
          }     
     }
     if ($qtd != "") {
          if ($tip == 1) { 
               $atu = $est + $qtd; 
               $dad['txt'] = 'Anterior: ' . number_format($est, 0, ",", ".") . ' Entrada: ' . number_format($qtd, 0, ",", ".") . ' Estoque Atual = ' . number_format($atu, 0, ",", ".");
          }
          if ($tip == 2) { 
               $atu = $est - $qtd; 
               $dad['txt'] = 'Anterior: ' . number_format($est, 0, ",", ".") . ' Saída: ' . number_format($qtd, 0, ",", ".") . ' Estoque Atual = ' . number_format($atu, 0, ",", ".");
          }
     }
     if ($atu < 0) {
          $dad['tip'] = 1;     
          $dad['men'] = 'Movimentação do estoque informado ficará NEGATIVO !';
     }
     echo json_encode($dad);
?>