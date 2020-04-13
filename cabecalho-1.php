<?php 
     $ret = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");

     if (isset($_SESSION['wrknomusu']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif (isset($_SESSION['wrktipban']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif (isset($_SESSION['wrklogusu']) == false) {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "*") {
          exit('<script>location.href = "login.php"</script>');   
     } elseif ($_SESSION['wrknomusu'] == "#") {
          exit('<script>location.href = "login.php"</script>');   
     }   
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação do menu principal">
          <span class="navbar-toggler-icon"></span>
     </button>
     <a class="navbar-brand" href="menu00.php">
          <img id="logo-2" src="img/logo-08.jpg">
     </a>
     <div class="collapse navbar-collapse align-self-center" id="navbarNav">
          <ul class="navbar-nav mr-auto text-center">
               <li class="nav-item">
               <a class="nav-link" href="man-usuario.php"><i class="fa fa-users fa-2x" aria-hidden="true"></i><br /> Usuários </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-jobs.php?ope=1&cod=0"> <i class="fa fa-briefcase fa-2x" aria-hidden="true"></i><br /> Jobs </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-cooperado.php"><i class="fa fa-address-card fa-2x" aria-hidden="true"></i><br /> Cooperados </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-alocacao.php"><i class="fa fa-handshake-o fa-2x" aria-hidden="true"></i><br /> Alocações </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="man-valor.php"><i class="fa fa-money fa-2x" aria-hidden="true"></i><br /> Valores </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="ger-valor.php"><i class="fa fa-download fa-2x" aria-hidden="true"></i><br /> Download </a>
               </li>
               <li class="nav-item">
                    <a class="nav-link" href="saida.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i><br /> Saída </a>
               </li>
          </ul>
          <span class="navbar-text text-center">
               <?php 
                    echo '<strong>' . $_SESSION['wrknomusu'] . '</strong>' . '<br />';
                    echo $_SESSION['wrklogusu'] . '<br />';
                    echo date('d/m/Y H:i:s') . '<br />';
               ?>
          </span>
     </div>
</nav>

<br /><br /><br /><br /><br /><br /><br />
