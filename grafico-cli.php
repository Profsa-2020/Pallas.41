<?php
     $cod = 0;
     session_start();
     include_once "dados.php";
     include_once "funcoes.php";
     $tab_w = array(array());
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }     
     for ($ind = 1; $ind <= 12; $ind++) {
          $tab_w['qtd'][] = 0;
          $tab_w['tit'][] = substr(mes_ano($ind), 0, 3);
          $cor_r = rand(0, 254);
          $cor_g = rand(0, 254);
          $cor_b = rand(0, 254);
          $tab_w['cor'][] = 'rgb(' . $cor_r . ',' . $cor_g . ',' . $cor_b . ')';  
     }
     $dti = date('Y') . "-" . "01" . "-" . "01" . " 00:00:00";
     $dtf = date('Y') . "-" . "12" . "-" . "31" . " 23:59:59";
     $com = "Select idcliente, clinome, datinc from tb_cliente where cliempresa = " . $_SESSION['wrkcodemp'] . " and datinc between '" . $dti . "' and '" . $dtf . "' ";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $mes = (int) date('m', strtotime($lin['datinc']));
          $tab_w['qtd'][$mes] = $tab_w['qtd'][$mes] + 1;
     }
     echo json_encode($tab_w);
?>