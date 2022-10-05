<?php
    include_once"conexao.php";
    $pagina = filter_input(INPUT_GET,"pagina",FILTER_SANITIZE_NUMBER_INT);

   
   if(!empty($pagina)){

    //calculando o inicio da visualização

    $qtd_result_pg = 10; //quantida de usuarios por pagina
    $inicio = ($pagina * $qtd_result_pg) - $qtd_result_pg; //exemplo na pagina 1 => (1*10)-10 : se inicia no resultado 0
    $query_usuarios = "SELECT id, nome, email FROM usuarios ORDER BY id DESC LIMIT $inicio, $qtd_result_pg";
    $result_usuarios = $pdo->prepare($query_usuarios);
    $result_usuarios->execute();

    $dados = "<div class='table-responsive'>
    <table class='table table-striped table-bordered'>
       <thead>
       <tr>
           <th>ID</th>
           <th>Nome</th>
           <th>E-Mail</th>
           <th>Ações</th>                        
        </tr>
       </thead>
   <tbody>";

 while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){

        extract($row_usuario); 
        
        $dados .= 
                "<tr>
                    <td>$id </td> 
                    <td>$nome</td>
                    <td>$email</td>
                    <td>
                    <button id='$id' type='button' class='btn btn-outline-primary btn-sm'
                    onclick='visUsuario($id)'>Visualizar</button> 

                    <button id='$id' type='button' class='btn btn-outline-secondary btn-sm' onclick='editUsuarioDados($id)'>Editar</button>

                    <button id='$id' type='button' class='btn btn-outline-danger btn-sm' onclick='apagarUsuarioDados($id)'>Excluir</button>


                    </td> 
                </tr>";
    };

    $dados .=" </tbody>
            </table>
            </div>";

//paginação - somar a quantidade de usuarios
$query_pg = "SELECT COUNT(id) AS num_result FROM usuarios";
$result_pg = $pdo->prepare($query_pg);
$result_pg->execute();
$row_pg = $result_pg->fetch(PDO::FETCH_ASSOC); //imprimir o resultado atraves da coluna

//quantidade de paginas
$quantidade_pg = ceil($row_pg['num_result'] / $qtd_result_pg);
$max_link =2;
//echo $quantidade_pg;


            $dados .='<nav aria-label="Page navigation example"><ul class="pagination pagination-sm justify-content-center">';

            $dados .= "<li class='page-item'> <a class='page-link' href='#' onclick='listarUsuarios(1)'>Primeira Página</a></li>";

            for($pag_ant = $pagina - $max_link; $pag_ant <= $pagina-1; $pag_ant++){
                if($pag_ant >= 1){
                $dados .= "<li class='page-item'><a class='page-link ' onclick='listarUsuarios($pag_ant)' href='#'>$pag_ant</a></li>"; 
                }
            }

            $dados .= "<li class='page-item active'><a class='page-link' href='#'>$pagina </a></li>";

            for($pag_depois = $pagina +1; $pag_depois <= $pagina + $max_link; $pag_depois++){
                if($pag_depois <= $quantidade_pg){
                    $dados .= " <li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios($pag_depois)'>$pag_depois</a></li>";

                }
               
            }
         
            $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='listarUsuarios($quantidade_pg)'>Última</a> </li>";
            $dados .=' </ul></nav>';
       

 echo $dados;
}else{
    echo "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontrado!</div>";
}
?>