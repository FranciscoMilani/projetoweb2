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
        echo json_encode(['html1' => '<br><br>Não há registros disponíveis para essa pesquisa',
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
            <th>Telefone</th>
            <th></th>
            <th></th>
        </tr>
    ";

    foreach ($respondentes as $resp) {
        $output .= "<tr>
                <td>{$resp->getId()}</td>
                <td>{$resp->getLogin()}</td>
                <td>{$resp->getNome()}</td>
                <td>{$resp->getEmail()}</td>
                <td>{$resp->getTelefone()}</td>
                <td>
                    <a href='ModificaRespondente.php?id={$resp->getId()}' class='btn btn-info m-1'>
                        <span class='bi bi-pencil-square'></span>
                    </a>
                    <a href='ExcluiRespondente.php?id={$resp->getId()}' class='btn btn-danger m-1'
                    onclick=\"return confirm('Tem certeza que quer excluir?')\">
                        <span class='bi bi-trash3-fill'></span>
                    </a>
                </td>
                <td>
                    <a href='ControleResultados.php?id={$resp->getId()}' class='btn btn-secondary m-1'>
                        <span class='bi bi-clipboard-check-fill'></span>
                    </a>
                </td>
            </tr>";
            
    }

    $output .= "
        </td>
    </tr>
    ";

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