<?php
include_once "conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //filter_default vai receber tudo como string

if(empty($dados['nome'])){
    $retorna = ['erro'=> true, 'msg'=>"<div class='alert alert-danger' role='alert'>
    Erro: Necessário preencher o campo Nome.
  </div>" ];

}elseif(empty($dados['email'])){
    $retorna = ['erro'=> true, 'msg'=>"<div class='alert alert-danger' role='alert'>
    Erro: Necessário preencher o campo Email.
  </div>" ];


}else{
    $query_usuario = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)"; // :variavel é a criação de um link que vai ser substituido depois
    $cad_usuario = $pdo->prepare($query_usuario);
    $cad_usuario->bindParam(':nome', $dados['nome']); //bindParam vai fazer a substituicao do link
    $cad_usuario->bindParam(':email', $dados['email']);    
    $cad_usuario->execute();

    
    if($cad_usuario->rowCount()){ //row count retorna a quantidade de linhas afetadas apos operacao no banco
        $retorna = ['erro'=>false, 'msg' => "<div class='alert alert-success' role='alert'>
        Usuário Cadastrado com Sucesso!!
      </div>"];
    }else{
        $retorna = ['erro'=> true, 'msg'=>"<div class='alert alert-danger' role='alert'>
        Erro ao Cadastrar Usuário!
      </div>" ];
    }
}

echo json_encode($retorna);


?>