<?php
     $qtd = 0;
     $cod = 0;
     $txt = "";
     session_start();
     $dad = array();     
     $ima = array();     
     $dad['msg'] = '';
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     include_once "dados.php";    
     include_once "funcoes.php";    
     $nro = quantidade_reg("Select P.*, C.clinome from (tb_produto P left join tb_cliente C on P.procliente = C.idcliente) where idproduto = " . $cod, $men, $reg);     
     if ($nro == 1 || $reg == true) {
          $txt .= '<span><strong>' . 'Código do Produto: ' . $reg['idproduto'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Descrição do Produto: ' . $reg['prodescricao'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Nome do Cliente: ' . $reg['clinome'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Número do Suite: ' . $reg['prosuite'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Unidade de Medida: ' . $reg['prounidade'] . '</strong></span><br />';
          $txt .= '<span><strong>' . 'Peso do Produto: ' . number_format($reg['propeso'], 4, ",", ".") . '</strong></span><br />';
          $txt .= '<hr />';
     }
     $com = "Select * from tb_produto_a where aneempresa = " . $_SESSION['wrkcodemp'] . " and aneproduto = " . $cod . " order by idanexo";
     $nro = carrega_tab($com, $reg);
     foreach ($reg as $lin) {
          $ima['nom'][] = $lin['anenome'];
          $ima['des'][] = $lin['anedescricao'];
          $ima['cam'][] = $lin['aneendereco'];
          $ima['tam'][] = $lin['anetamanho'];
          $ima['ext'][] = $lin['aneextensao'];          
     }
     for ($ind = 0; $ind < $nro; $ind++) {
          $txt .= '<div class="row">';
          if ($nro >= 2) {
               $txt .= '<div class="col-md-6">';
               if (isset($ima['cam'][$qtd]) == true) {
                    if ($ima['ext'][$qtd] == "mp4" || $ima['ext'][$qtd] == "avi") {
                         $txt .= '<video controls><source src="' . $ima['cam'][$qtd] . '" type="video/mp4"></video>';
                    } else {
                         $txt .= '<img class="img-fluid" src="' . $ima['cam'][$qtd] . '">';
                    }
                    $qtd = $qtd + 1;
               }
               $txt .= '</div>';
               $txt .= '<div class="col-md-6">';
               if (isset($ima['cam'][$qtd]) == true) {
                    if ($ima['ext'][$qtd] == "mp4" || $ima['ext'][$qtd] == "avi") {
                         $txt .= '<video controls><source src="' . $ima['cam'][$qtd] . '" type="video/mp4"></video>';
                    } else {
                         $txt .= '<img class="img-fluid" src="' . $ima['cam'][$qtd] . '">';                    
                    }
                    $qtd = $qtd + 1;
               }
               $txt .= '</div>';

          } else {
               $txt .= '<div class="col-md-12">';
               if (isset($ima['cam'][$ind]) == true) {
                    if ($ima['ext'][$qtd] == "mp4" || $ima['ext'][$qtd] == "avi") {
                         $txt .= '<video controls><source src="' . $ima['cam'][$ind] . '" type="video/mp4"></video>';
                    } else {                    
                         $txt .= '<img class="img-fluid" src="' . $ima['cam'][$ind] . '">';
                    }
               }
               $txt .= '</div>';
          }
          $txt .= '</div>';
     }
     $dad['txt'] = $txt;
     echo json_encode($dad);
?>