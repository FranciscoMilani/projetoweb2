<?php 
    include_once "Fachada.php";
    $dao = $factory->getElaboradorDao();

    $limit = $_POST['limit'];
    $page = $_POST['page'];
    $query = $_POST['query'];
    $offset = 1;

    if($_POST['page'] > 1)
    {
        $offset = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    } else {
        $offset = 0;
    }

    $elaboradores = $dao->buscaPorNomePaginado($query, $limit, $offset);
    $total_data = $dao->contaComNome($query);

    if (!$elaboradores || empty($elaboradores)){
        header('Content-Type: application/json');
        echo json_encode(['html1' => '<br><br>Nenhum registro foi encontrado',
                          'html2' => '']);
        exit;
    }

    $output .= " 
    <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
        <tr class=\"table-head\">
            <th>Id</th>
            <th>Login</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Instituição</th>
            <th>Admin</th>
            <th></th>
        </tr>
    ";

    foreach ($elaboradores as $elab) { 
        $output .= "
        <tr>
            <td>{$elab->getId()}</td>
            <td>{$elab->getLogin()}</td>
            <td>{$elab->getNome()}</td>
            <td>{$elab->getEmail()}</td>
            <td>{$elab->getInstituicao()}</td>
        ";
            if ($elab->getIsAdmin()) {
                $output .= "<td>Sim</td>";
            } else {
                $output .= "<td>Não</td>";
            }
            $output .= "
            <td>
                <a href='ModificaElaborador.php?id={$elab->getId()}' class='btn btn-info'>
                    <span class='bi bi-pencil-square'></span>
                </a> 
        ";
        
            if (!$elab->getIsAdmin()){
                $output .= "
                <a href='ExcluiElaborador.php?id={$elab->getId()}' class='btn btn-danger'
                onclick=\"return confirm('Tem certeza que quer excluir?')\">
                    <span class='bi bi-trash3-fill'></span>
                </a>
                ";
            }
            $output .= "
            </td>
        </tr>
    ";
    }

    $output .= "
    </table>
    ";

    // Inicia o buffer de saída
    ob_start();

    // Inclui o layout da paginação
    include_once "LayoutPaginacao.php";

    // Atribui a saída em string numa variável
    $output2 = ob_get_clean();

    // Constrói array com saída dos dois arquivos PHP
    $response = array(
        'html1' => $output,
        'html2' => $output2
    );
        
    // Define content-type e envia JSON codificado para ser recebido pelo AJAX
    header('Content-Type: application/json');
    echo json_encode($response);
?>