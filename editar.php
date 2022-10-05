<?php
include_once "conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT); //filter_default vai receber tudo como string

if(empty($dados['id'])){
  $retorna = ['erro'=> true, 'msg'=>"<div class='alert alert-danger' role='alert'>
  Erro: Tente mais tarde!
</div>" ];

}else if(empty($dados['nome'])){
    $retorna = ['erro'=> true, 'msg'=>"<div class='alert alert-danger' role='alert'>
    Erro: Necessário preencher o campo Nome.
  </div>" ];

}elseif(empty($dados['email'])){
    $retorna = ['erro'=> true, 'msg'=>"<div class='alert alert-danger' role='alert'>
    Erro: Necessário preencher o campo Email.
  </div>" ];


}else{
  $query_usuario = "UPDATE usuarios SET nome=:nome, email=:email WHERE id=:id";
   
    $edit_usuario = $pdo->prepare($query_usuario);
    $edit_usuario->bindParam(':nome', $dados['nome']); //bindParam vai fazer a substituicao do link
    $edit_usuario->bindParam(':email', $dados['email']); 
    $edit_usuario->bindParam(':id', $dados['id']);   
    //$edit_usuario->execute();

    
    if($edit_usuario->execute()){ //row count retorna a quantidade de linhas afetadas apos operacao no banco
        $retorna = ['erro'=>false, 'msg' => "<div class='alert alert-success' role='alert'>
        Usuário Editado com Sucesso!!
      </div>"];
    }else{
        $retorna = ['erro'=> true, 'msg'=>"<div class='alert alert-danger' role='alert'>
        Erro ao Editar Usuário!
      </div>" ];
    }
}

echo json_encode($retorna);


?>