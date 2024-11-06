<?php
$host = "localhost";
$user = "root";
$pass ="";
$dbname = "banco";

try{
    $conn = new PDO("mysql:host=$host;dbname=".$dbname, $user, $pass);
   // echo "Conexao com o banco de dados realizada com sucesso";

} catch(PDOException $err){
    echo "Erro: Conexao com o banco de dados não foi realizada com sucesso. Erro gerado " . $err->getMessage();
}
