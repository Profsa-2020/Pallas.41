<?php

function ligar_bco(&$err) {
     try {
          if (isset($_SESSION['wrktipban']) == false) {
               exit('<script>location.href = "login.php"</script>');                       
          }
          $err = ''; $ip  = getenv("REMOTE_ADDR");
          if ( $_SESSION['wrktipban'] == "mysql" ) { 
               if ($ip == "127.0.0.1") {
                    $dsn = 'mysql:host=localhost; dbname=bd_mylogbox'; 
                    $usu = 'root';
                    $pas = '';
               } else {
                    $dsn = 'mysql:host=localhost; dbname=profsa92_bd_mylogbox'; // Acesso site Profsa
                    $usu = 'profsa92_profsa';
                    $pas = 'pallas41';     
               }
               $pdo = new PDO($dsn, $usu, $pas) or die('Erro na conexão PDO (MySql ) com o banco de dados bd_mylogbox');       
          }   
          if ( $_SESSION['wrktipban'] == "access" ) { 
               $mdb = __DIR__ . '/' . 'prodWeb.mdb';
               $str = "odbc:DRIVER={Microsoft Access Driver (*.mdb)};DBQ=$mdb;";
               $pdo = new PDO($str) or die('Erro na conexão PDO (Access) com o banco de dados bd_mylogbox');                 
          }   
          if ( $_SESSION['wrktipban'] == "postgre" ) { 
               $dsn = 'pgsql:host=localhost; port=5432;dbname=bd_mylogbox'; 
               $usu = 'mylogbox';
               $pas = 'profsa1993';
               $pdo = new PDO($dsn, $usu, $pas) or die('Erro na conexão PDO (PostGre) com o banco de dados bd_mylogbox');       
          }   
          return $pdo;
     }
     catch (PDOException $erro) {
          $err = $erro->getMessage();
     }
     catch (Exception $erro) {
          $err = $erro->getMessage();
     }

}

function usuario_log($tip, $ema, $sen, &$reg) {
     $qtd = 0; 
     $reg = array();
     $con_bco = ligar_bco($erro);
     if ($erro != "") {
          echo '<script>alert("Erro -> ' . $erro . ' !");</script>';
     }
     $sen = base64_encode($sen);
     if ($tip == 1) {
          $com = "Select * from tb_usuario where usuemail = '" . $ema . "'";
     } else if ($tip == 2) {
          $com = "Select * from tb_usuario where usuemail = '" . $ema . "' and ususenha = '" . $sen . "'";
     }
	$sql = $con_bco->prepare($com);
     $sql->execute();
     $qtd = $sql->rowCount();
     $col = $sql->columnCount();
	while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
          $reg = $row;
     }
     return $qtd;
}

function qtd_registros($emp, $tab) {
     $qtd = 0;
     $con_bco = ligar_bco($erro);
     $com = "Select count(*) as linhas from " . $tab;
	$sql = $con_bco->prepare($com);
	$sql->execute();
	while ($row = $sql->fetch()) {
          $qtd = $row['linhas']; 
     }
     return $qtd;
}

function comando_tab($com, &$nro, &$ult, &$men) {
try {
     $ret = 0; $nro = 0; $men = "";
     $con_bco = ligar_bco($erro);
     $sql = $con_bco->prepare($com);
     $ret = $sql->execute();  // True -> OK
     $nro = $sql->rowCount();
     $ult = $con_bco->lastInsertId();
     return $ret;
}
catch (PDOException $erro) {
          $men = $erro->getMessage();
     }
     catch (Exception $erro) {
          $men = $erro->getMessage();
     }
}

function quantidade_reg($com, &$men, &$reg) {
try {
     $nro = 0; $men = ""; 
     $con_bco = ligar_bco($erro);
     $sql = $con_bco->prepare($com);
     $sql->execute();
     $reg = $sql->fetch(PDO::FETCH_ASSOC);
     $nro = $sql->rowCount();
     return $nro;
}
     catch (PDOException $erro) {
          $men = $erro->getMessage();
     }
     catch (Exception $erro) {
          $men = $erro->getMessage();
     }
}

function carrega_reg($com, &$reg) {
     $con_bco = ligar_bco($erro);
	$sql = $con_bco->prepare($com);
     $sql->execute();
     $reg = $sql->fetch(PDO::FETCH_ASSOC);
     $nro = $sql->rowCount();
     return $nro;
}

function carrega_tab($com, &$reg) {
try {
     $con_bco = ligar_bco($erro);
	$sql = $con_bco->prepare($com);
     $sql->execute();
     $reg = $sql->fetchAll();
     $nro = $sql->rowCount();
     return $nro;
}
     catch (PDOException $erro) {
          $men = $erro->getMessage();
     }
     catch (Exception $erro) {
          $men = $erro->getMessage();
     }
}

?>
