<?php
     $sta = 0;
     $tip = 0;
     $tab = array();
     session_start();
     $tab['men'] = "";
     include_once "funcoes.php";
     if (isset($_REQUEST['tip']) == true) { $tip = $_REQUEST['tip']; }
     if (isset($_REQUEST['nom']) == true) { $nom = $_REQUEST['nom']; }
     if (isset($_REQUEST['ape']) == true) { $ape = $_REQUEST['ape']; }
     if (isset($_REQUEST['cpf']) == true) { $cpf = limpa_nro($_REQUEST['cpf']); }
     if ($tip == 1) {
          if ($ape == "") {
               $tab['ape'] = primeiro_nom($nom);
          }
     }
     if ($tip == 2) {
          $sta = valida_cpf($cpf);
          if ($sta != 0) {
               $tab['men'] = "Dígito de controle do C.p.f. informado não está correto";
          }
     }
     echo json_encode($tab);     

?>