<html>  
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>PHP Test</title>
    <?php
    $nomeVendedorErr = $metaVendasErr = $metaVendasErr = $horaValorErr = $qtdHorasErr = "";
    $nomeVendedor = $metaVendas = $metaVendas = $horaValor = $qtdHoras = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      if (empty($_POST["nomeVendedor"])){
        $nomeVendedorErr = "Vendedor é obrigatorio";
      } else {
        $nomeVendedor = test_input($_POST["nomeVendedor"]);
      };

      if(empty($_POST["metaVendas"])){
        $metaVendasErr = "Meta de vendas é obrigatorio";
      } else {
        $metaVendas = test_input($_POST["metaVendas"]);
      }

      if(empty($_POST["horaValor"])){
        $horaValorErr = "Valor da hora é obrigatorio";
      } else {
        $horaValor = test_input($_POST["horaValor"]);
      }

      if(empty($_POST["qtdHoras"])){
        $qtdHorasErr = "Quantidade de horas é obrigatorio";
      } else {
        $qtdHoras = test_input($_POST["qtdHoras"]);
      }
    }

      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    ?>
  </head>
  
  <body>
    <div id="formulario">
      <form method="POST">
        <div class="separador">
          <label>Nome do vendedor: </label>
          <input type="text" id="nomeVendedor" name="nomeVendedor">
        </div>
        <div class="separador">
          <label>Meta de vendas: </label>
          <input type="number" id="metaVendas" name="metaVendas">
        </div>
        <div class="separador">
          <label>Valor hora: </label>
          <input type="number" id="horaValor" name="horaValor">
        </div>
        <div class="separador">
          <label>Quantidade de horas trabalhadas: </label>
          <input type="number" id="qtdHoras" name="qtdHoras"> 
        </div>
        <div class="separador">
          <label>Valor das vendas realizadas: </label>
          <input type="number" id="vendasFeitas" name="vendasFeitas">
        </div>
        <div class="separador">
          <input type="submit" id="calcular" name="calcular">
        </div>
        <?php (float)$salarioBruto = (float)$qtdHoras = (float)$horaValor = (float)$vlrComiss = (float)$salarioBonus = (float)$inssV1 = (float)$inssV2 = (float)$inssV3 = (float)$inssV4 = (float)$inssTotal = (int)$irV1 = (int)$irV2 = (int)$irV3 = (int)$irV4 = (float)$irTotal = (float)$salarioSemInss = (float)$totalDesc = (float)$totalLiq = "";

          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $nomeVendedor = $_POST['nomeVendedor'];
            (int)$metaVendas = $_POST['metaVendas'];
            (int)$horaValor = $_POST['horaValor'];
            (int)$qtdHoras = $_POST['qtdHoras'];
            (int)$vendasFeitas = $_POST['vendasFeitas'];

          if (isset($_POST['calcular'])) {
            if ($salarioBruto < 0 || $qtdHoras < 0 || $horaValor <0 ) {
              echo 'Valor inválido!';
              } else {
                $salarioBruto = $qtdHoras * $horaValor;

                  #Variáveis INSS
                  $baseInss1 = 1320;
                  $baseInss2 = 2571.29;
                  $baseInss3 = 3856.94;
                  $baseInss4 = 7507.49;
                  $aliqInss1 = 0.075;
                  $aliqInss2 = 0.09;
                  $aliqInss3 = 0.12;
                  $aliqInss4 = 0.14;

                  if ($salarioBruto > $metaVendas) {
                    $vlrComiss = $salarioBruto * 0.03;
                    $salarioBonus = $salarioBruto + $vlrComiss;
                    echo "O $nomeVendedor, vendeu R$$salarioBruto e passou a meta de R$$metaVendas. E vai receber R$$salarioBonus.";
                  } else {
                    echo "O $nomeVendedor, vendeu R$$salarioBruto e não passou a meta de R$$metaVendas. E vai receber R$$salarioBruto.";
                  }

                  #Calculo para INSS
                  if ($salarioBonus <= $baseInss1) {
                    $inssV1 = $salarioBonus * $aliqInss1;
                    $inssTotal = $inssV1;
                  } else if ($salarioBonus > $baseInss1 && $salarioBonus <= $baseInss2) {
                    $inssV1 = $aliqInss1 * $baseInss1;
                    $inssV2 = $aliqInss2 * ($salarioBonus - $baseInss1);
                    $inssTotal = $inssV2 + $inssV1;
                  } else if ($salarioBonus > $baseInss2 && $salarioBonus <= $baseInss3) {
                    $inssV1 = $aliqInss1 * $baseInss1;
                    $inssV2 = $aliqInss2 * ($baseInss2 - $baseInss1);
                    $inssV3 = $aliqInss3 * ($salarioBonus - $baseInss2);
                    $inssTotal = $inssV2 + $inssV1 + $inssV3;
                  } else if ($salarioBonus > $baseInss3 && $salarioBonus <= $baseInss4) {
                    $inssV1 = $aliqInss1 * $baseInss1;
                    $inssV2 = $aliqInss2 * ($baseInss2 - $baseInss1);
                    $inssV3 = $aliqInss3 * ($baseInss3 - $baseInss2);
                    $inssV4 = $aliqInss4 * ($salarioBonus - $baseInss3);
                    $inssTotal = $inssV2 + $inssV1 + $inssV3 + $inssV4;
                  } else if ($salarioBonus > $baseInss4) {
                    $inssV1 = $aliqInss1 * $baseInss1;
                    $inssV2 = $aliqInss2 * ($baseInss2 - $baseInss1);
                    $inssV3 = $aliqInss3 * ($baseInss3 - $baseInss2);
                    $inssV4 = $aliqInss4 * ($baseInss4 - $baseInss3);
                    $inssTotal = $inssV2 + $inssV1 + $inssV3 + $inssV4;
                  }

                  #Salário sem INSS
                  $salarioSemInss = $salarioBonus - $inssTotal;

                  #Variáveis IR
                  $baseIr1 = 2112.01;
                  $baseIr2 = 2826.65;
                  $baseIr3 = 3751.05;
                  $baseIr4 = 4664.68;
                  $aliqIr1 = 0.075;
                  $aliqIr2 = 0.15;
                  $aliqIr3 = 0.225;
                  $aliqIr4 = 0.275;

                  #Calculo para IR
                  if ($salarioSemInss < 0){
                    if ($salarioSmInss > $baseIr1 && $salarioSemInss <= $baseIr2){
                      $irV1 = $salarioSemInss * $aliqIr1;
                      $irTotal = $irV1;
                    } else if ($salarioSemInss > $baseIr2 && $salarioSemInss <= $baseIr3){
                      $irV2 = $salarioSemInss * $aliqIr2;
                      $irTotal = $irV1 + $irV2;
                    } else if ($salarioSemInss > $baseIr3 && $salarioSemInss <= $baseIr4){
                      $irV3 = $salarioSemInss * $aliqIr3;
                      $irTotal = $irV1 + $irV2 + $irV3;
                    } else if ($salarioSemInss > $baseIr4){
                      $irV4 = $salarioSemInss * $aliqIr4;
                      $irTotal = $irV1 + $irV2 + $irV3 + $irV4;
                    }
 
                  if ($irTotal > 0){
                    $totalDesc = (float)$inssTotal + (float)$irTotal;
                  } else {
                    $totalDesc = (float)$inssTotal;
                  }
                  
                  $totalLiq = $salarioBonus - $totalDesc;
                }
              }
            }
          }
        ?>
      </form>
      <br>
      <table style="width:100%">
        <tr id="header">
          <th id="header01">Descrição</th>
          <th id="header02">Descontos</th>
          <th id="header03">Proventos</th>
        </tr>
        <tr id="valorBruto">
          <td id="valorBruto_title">Salário Bruto</td>
          <td id="valorBruto_desc" name="valorBruto_desc"><?php echo "R$ 0"; ?></td>
          <td id="valorBruto_prov" name="valorBruto_prov"><?php echo "R$ $salarioBruto"; ?></td>
        </tr>
        <tr id="comissao">
          <td id="comissao_title">Comissão</td>
          <td id="comissao_desc" name="comissao_desc"><?php echo "R$ 0"; ?></td>
          <td id="comissao_prov" name="comissao_prov"><?php echo "R$ $vlrComiss"; ?></td>
        </tr>
        <tr id="totVlrBruto">
          <td id="totVlrBruto_title">Total Bruto</td>
          <td id="totVlrBruto_desc" name="totVlrBruto_desc"><?php echo "R$ 0"; ?></td>
          <td id="totVlrBruto_prov" name="totVlrBruto_prov"><?php echo "R$ $salarioBonus"; ?></td>
        </tr>
        <tr id="inss">
          <td id="inss_title">INSS</td>
          <td id="inss_desc" name="inss_desc"><?php echo "R$ $inssTotal"; ?></td>
          <td id="inss_prov" name="inss_prov"><?php echo "R$ 0"; ?></td>
        </tr>
        <tr id="ir">
          <td id="ir_title">Imposto de Renda</td>
          <td id="ir_desc" name="ir_desc"><?php echo "R$ $irTotal"; ?></td>
          <td id="ir_prov" name="ir_prov"><?php echo "R$ 0"; ?></td>
        </tr>
        <tr id="descont">
          <td id="descont_title">Descontos Totais</td>
          <td id="descont_desc" name="descont_desc"><?php echo "R$ $totalDesc"; ?></td></td>
          <td id="descont_prov" name="descont_prov"><?php echo "R$ 0"; ?></td>
        </tr>
        <tr id="valorLiq">
          <td id="valorLiq_title">Salário Líquido</td>
          <td id="valorLiq_desc" name="valorLiq_desc"><?php echo "R$ 0"; ?></td>
          <td id="valorLiq_prov" name="valorLiq_prov"><?php echo "R$ $totalLiq" ?></td>
        </tr>
      </table>
    </div>
  </body>
</html>