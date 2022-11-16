<?php 

print 'Digitada CEP: ' .  $_POST['CEP'];

$CEPS = $_POST['CEP'];
$CEPSLENS = strlen($CEPS);
print '<br/> Letras: ' . $CEPSLENS;

if($CEPSLENS == 8){
    print '<p style="color: green;"> CEP está válida </p>';
    function calcular_frete($cep_origem,
    $cep_destino,
    $peso,
    $valor,
    $tipo_do_frete,
    $altura = 6,
    $largura = 20,
    $comprimento = 20){
    
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
    $url .= "nCdEmpresa=";
    $url .= "&sDsSenha=";
    $url .= "&sCepOrigem=" . $cep_origem;
    $url .= "&sCepDestino=" . $cep_destino;
    $url .= "&nVlPeso=" . $peso;
    $url .= "&nVlLargura=" . $largura;
    $url .= "&nVlAltura=" . $altura;
    $url .= "&nCdFormato=1";
    $url .= "&nVlComprimento=" . $comprimento;
    $url .= "&sCdMaoProria=n";
    $url .= "&nVlValorDeclarado=" . $valor;
    $url .= "&sCdAvisoRecebimento=n";
    $url .= "&nCdServico=" . $tipo_do_frete;
    $url .= "&nVlDiametro=0";
    $url .= "&StrRetorno=xml";
    
    // Sedex: 40010
    // Pac: 41106
    
    $xml = simplexml_load_file($url);
    
    return $xml->cServico;  
} 

$val = (calcular_frete($CEPS,'04752005',2,1000,'40010'));
$val_2 = (calcular_frete($CEPS,'04752005',2,1000,'41106'));
$_POST['CORREIOS_SEDEX'] = $val->Valor;
$_POST['CORREIOS_PAC'] = $val_2->Valor; 

} else{
    print '<br/><p style="color: red;"> CEP está inválida </p>';
    $_POST['CEP'] = '';    

}
 
?>
<style>
    *{
        font-family: arial;
    }
</style>
<form method="post" action="index.php">
     <input type="radio" id="PAC" name="radios"/><label>PAC - Preço: <?php print $_POST['CORREIOS_SEDEX']; ?> </label> <br/>
     <input type="radio" id="Sedex" name="radios"/><label>Sedex -  Preço: <?php print $_POST['CORREIOS_PAC']; ?></label> <br/>
     <br/>
    <input type="text" placeholder="Digite seu CEP" name="CEP">
    <button type="submit">Calcular Frete</button>
</form>