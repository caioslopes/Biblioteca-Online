<?php 
require('DataBase.php');


// Store datetime in variable today
$today = new DateTimeImmutable();   
$dia = new DateInterval('P1D'); 
$soma = $today->add($dia);
$amanha = $soma->format('d/m/Y/H/i');
$hoje = $today->format('d/m/Y/H/i');

$sqlcomparacao = $conn->prepare("SELECT data_amanha FROM reserva_temp;");
$sqlcomparacao->execute();
$resultcomparacao = $sqlcomparacao->get_result();

$ddt = null;

foreach ($resultcomparacao as $comparaçao){
    $ddt = $comparaçao['data_amanha'];
    
    
    /* echo "<pre>"; print_r($ddt); echo "</pre>"; exit;  */
};
    
if($ddt <= $hoje){

    $sqlDelete = $conn->prepare("DELETE FROM reserva_temp WHERE data_amanha <= $hoje");
    $sqlDelete->execute();
    header('location: index.php?status=success');
}else{
    header('location: index.php?status=error');
}



?>

