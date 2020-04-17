<?php
     $qtd = 2;
     $cod = 0;
     $txt = "";
     session_start();
     $dad = array();     
     $dad['msg'] = '';
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     include_once "dados.php";    
     include_once "funcoes.php";    
     $nro = quantidade_reg("Select * from tb_cliente where idcliente = " . $cod, $men, $reg);     
     if ($nro == 1 || $reg == true) {
          $txt .= '<span><strong>' . 'Código do Cliente: ' . $reg['idcliente'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Nome do Cliente: ' . $reg['clinome'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Número do Suite: ' . $reg['clisuite'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Número do CPF: ' . mascara_cpo($reg['clicpf'],'   .   .   -  ') . '</strong></span><br />';
          $txt .= '<hr />'; 
          $txt .= '<span class="cor-1">' . '1 - Título do Endereço: ' . $reg['clititulo'] . '</span><br />';
          $txt .= '<span>' . 'Endereço: ' . $reg['cliendereco'] . ', ' . $reg['clinumero'] . ' ' . $reg['clicomplemento'] . '</span><br />';
          $txt .= '<span>' . 'CEP: ' . mascara_cpo($reg['clicep'], '     -   ') . ' Bairro: ' . $reg['clibairro'] . ' Cidade: ' . $reg['clicidade'] . ' UF: ' . $reg['cliestado'] . '</span><br />';
          $txt .= '<span>' . 'Telefone: ' . $reg['clitelefone'] . ' - Celular: ' . $reg['clicelular'] . ' - E-Mail: ' . $reg['cliemail'] . '</span><br />';
     }
     $com = "Select * from tb_cliente_e where endempresa = " . $_SESSION['wrkcodemp'] . " and endcliente = " . $cod . " order by idendereco";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $txt .= '<hr />';
          $txt .= '<span class="cor-1">' . $qtd . ' - Título do Endereço: ' . $lin['endtitulo'] . '</span><br />';
          $txt .= '<span>' . 'Endereço: ' . $lin['endendereco'] . ', ' . $lin['endnumero'] . ' ' . $lin['endcomplemento'] . '</span><br />';
          $txt .= '<span>' . 'CEP: ' . mascara_cpo($lin['endcep'], '     -   ') . ' Bairro: ' . $lin['endbairro'] . ' Cidade: ' . $lin['endcidade'] . ' UF: ' . $lin['endestado'] . '</span><br />';
          $txt .= '<span>' . 'Telefone: ' . $lin['endtelefone'] . ' - Celular: ' . $lin['endcelular'] . ' - E-Mail: ' . $lin['endemail'] . '</span><br />';
          $qtd += 1;
     }
     $dad['txt'] = $txt;
     echo json_encode($dad);
?>