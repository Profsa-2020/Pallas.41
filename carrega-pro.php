<?php
     $cli = 0;
     $pro = 0;
     session_start();
     $dad = array();     
     $dad['men'] = '';
     if (isset($_REQUEST['cli']) == true) { $cli = $_REQUEST['cli']; }
     if (isset($_REQUEST['pro']) == true) { $pro = $_REQUEST['pro']; }
     include_once "dados.php";    
     include_once "funcoes.php";    
     $dad['txt'] =  '<option value="0" selected="selected">Selecione produto desejado ...</option>';
     $com = "Select idproduto, prodescricao from tb_produto where prostatus = 0  and proempresa = " . $_SESSION['wrkcodemp'] . " and procliente = " . $cli . " order by prodescricao";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idproduto'] != $pro) {
               $dad['txt'] .= '<option value ="' . $lin['idproduto'] . '">' . $lin['prodescricao'] . '</option>'; 
          }else{
               $dad['txt'] .= '<option value ="' . $lin['idproduto'] . '" selected="selected">' . $lin['prodescricao'] . '</option>';
          }
     }
     echo json_encode($dad);
?>