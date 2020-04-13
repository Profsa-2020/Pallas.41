<?php

function ligar_bco(&$err) {
     try {
          $err = '';
          if ( $_SESSION['wrktipban'] == "mysql" ) { 
               $dsn = 'mysql:host=localhost; dbname=bd_mylogbox'; 
               $usu = 'root';
               $pas = '';
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

function comando_usu($com, &$nro) {
     $ret = 0; $nro = 0;
     $con_bco = ligar_bco($erro);
     $sql = $con_bco->prepare($com);
     $ret = $sql->execute();  // True -> OK
     $nro = $sql->rowCount();
     return $ret;
}

?>
