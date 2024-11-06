<?php
echo'<h1><center>Pesquisando CPF duplicado no banco MySQL com PHP</center></h1>';

$host = "localhost";
$user = "root";
$pass ="";
$dbname = "banco";

$conn = new mysqli($host,$user,$pass,$dbname);

if($conn->connect_error){
    die("Conexao falhou:".$conn->connect_error);
};
echo "Com conexção MySQLi".'<br><br>';
    $sql = "SELECT COUNT(cpf)AS contador, cpf FROM cliente GROUP BY cpf HAVING COUNT(cpf) >1 ORDER BY count(cpf) DESC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
           $cpf = $row["cpf"];
           $contador = $row["contador"];
           echo "CPF : $cpf - Duplicatas: $contador".'<br>';  
        };   
    }else{
        echo"Nenhum resultado encontrado";
    }

    // outro metodo

    echo '<br>'."Com conexção PDO".'<br><br>';

include_once "conexao.php";

    $query_usuarios = "SELECT COUNT(cpf)AS contado, cpf FROM cliente GROUP BY cpf HAVING COUNT(cpf)  >1 ORDER BY count(cpf) DESC";
    $result_usuarios = $conn->prepare($query_usuarios);
    $result_usuarios->execute();
    
    if(($result_usuarios) and ($result_usuarios->rowCount() != 0)){
        while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
            $cpf = $row_usuario["cpf"];
            $contador = $row_usuario["contado"];
           echo "O cpf $cpf foi duplicado $contador vezes".'<br>';
        };

    };

    // outro metodo

    echo '<br>'."Enviando para json_encode".'<br><br>';

    $query = "SELECT COUNT(cpf)AS conta, cpf FROM cliente GROUP BY cpf HAVING COUNT(cpf)  >1 ORDER BY count(cpf) DESC";
    $result_usuario = $conn->prepare($query);
    $result_usuario->execute();

    if(($result_usuario) and ($result_usuario->rowCount() != 0)){

    while($row_user = $result_usuario->fetch(PDO::FETCH_ASSOC)){
        $dados[] = [
           'cpf' => $row_user['cpf'],
           'Conta' => $row_user['conta'] 
        ];
    }
   
    $retorna = ['erro' => false, 'dados' => $dados];
}else{
    $retorna = ['erro' => true, 'msg' => "<font color=red>Erro: Nenhum usuário encontrado"];
};

echo json_encode($retorna);
    