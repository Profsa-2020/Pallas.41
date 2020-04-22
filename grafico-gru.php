<?php
     $cod = 0;
     session_start();
     include_once "dados.php";
     include_once "funcoes.php";
     $tab_w = array(array());
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }     
     $com = "Select progrupo, G.grudescricao, count(*) as qtde from (tb_produto P left join tb_grupo G on P.progrupo = G.idgrupo) where proempresa = " . $_SESSION['wrkcodemp'] . " group by progrupo";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $tab_w['qtd'][]  = $lin['qtde'];
          $tab_w['tit'][]  = ($lin['grudescricao'] == null ? '**********' : $lin['grudescricao']);
          $cor_r = rand(0,254);
          $cor_g = rand(0,254);
          $cor_b = rand(0,254);
          $tab_w['cor'][] = 'rgb(' . $cor_r . ',' . $cor_g . ',' . $cor_b . ')';  
     }
     echo json_encode($tab_w);
?>