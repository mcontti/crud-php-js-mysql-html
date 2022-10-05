<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "celke";
    $port = 3306;

    try{
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=".$dbname,$user,$pass);
        
       // echo "conexao com BD realizada com Sucesso! <br>";
    }catch(PDOException $err){
        echo "conexão com BD falhou!" . $err->getMessage();
    }

?>