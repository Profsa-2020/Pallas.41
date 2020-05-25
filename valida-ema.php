<?php
     $ema = "";
     $dad = array();     
     session_start();
     $dad['ret'] = 00;
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['ema']) == true) { $ema = $_REQUEST['email']; }
     $sql = mysqli_query($conexao,"Select idsenha from tb_usuario where usuemail = '$ema'");
     if (mysqli_num_rows($sql) == 1) {
          $dad['ret'] = 1;
     }elseif (mysqli_num_rows($sql) >= 2) {
          $dad['ret'] = 2;
     }

     echo json_encode($dad);

?>