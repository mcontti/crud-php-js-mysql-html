<?php
include_once "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_usuario = "DELETE FROM usuarios WHERE id=:id";
    $result_usuario = $pdo->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id);
    
    
    if($result_usuario->execute()){
      $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Usuário Apagado com sucesso!</div>"];
    }else{
      $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro ao Excluir Usuário!</div>"];
    }
  }
  echo json_encode($retorna);