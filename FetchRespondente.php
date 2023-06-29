<?php 
    include_once "Fachada.php";
    $dao = $factory->getRespondenteDao();

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

    $respondentes = $dao->buscaPorNomePaginado($query, $limit, $offset);
    $total_data = $dao->contaComNome($query);

    if (!$respondentes || empty($respondentes)){
        header('Content-Type: application/json');
        echo json_encode(['html1' => '<br><br>Nenhum registro foi encontrado',
                          'html2' => '']);
        exit;
    }

    $output .= " 
    <table class=\"table table-hover table-striped p-3 rounded-3 overflow-hidden align-middle\">
        <thead class=\"table-head\">
            <th>Id</th>
            <th>Login</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th></th>
        </thead>
    ";

    foreach ($respondentes as $resp) {
        $output .= "<tr class=\"destacavel\" onclick=\"carregaDetalhe(this)\">
                <td>{$resp->getId()}</td>
                <td>{$resp->getLogin()}</td>
                <td>{$resp->getNome()}</td>
                <td>{$resp->getEmail()}</td>
                <td>{$resp->getTelefone()}</td>
                <td class='align-items-center'>
                    <a href='ModificaRespondente.php?id={$resp->getId()}' class='btn btn-info w-100'>
                        <span class='bi bi-pencil-square p-2'></span>
                    </a>
                    <a href='ExcluiRespondente.php?id={$resp->getId()}' class='btn btn-danger mt-1 w-100'
                    onclick=\"return confirm('Tem certeza que quer excluir?')\">
                        <span class='bi bi-trash3-fill p-2'></span>
                    </a>
                </td>
            </tr>";  
    }

    $output .= "
    </table>
    ";

    // Inicia o buffer de saída
    ob_start();

    // Inclui o layout da paginação
    include_once "LayoutPaginacao2.php";

    // Atribui a saída em string numa variável
    $output3 = ob_get_clean();

    // Constrói array com saída dos dois arquivos PHP
    $response = array(
        'html1' => $output,
        'html2' => $output3
    );
        
    // Define content-type e envia JSON codificado para ser recebido pelo AJAX
    header('Content-Type: application/json');
    echo json_encode($response);
?>