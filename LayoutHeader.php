<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="public/imagens/icone.png">


    <link rel="stylesheet" href="public/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <script
        src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    
        if (isset($_GET['mensagem'])){
            $mensagem = @$_GET['mensagem'];
            if (!empty($mensagem)) {
                echo "<script data-tipo_tabela=\"$tipoLista\">alert('$mensagem');</script>";
            }
        }

        if(isset($tipoLista)){
            if ($tipoLista == "OfertaQuestionarioRespondente"){
                echo "<script src=\"public/js/marcarLinha.js\"></script>";
                echo "<script src=\"public/js/geraTabelaOfertarQuestionario.js\"></script>";
                echo "<script src=\"public/js/geraTabelaOfertarRespondente.js\"></script>";
            } else if ($tipoLista == "RespondenteResultado"){
                echo "<script src=\"public/js/mestreDetalheSubmissao.js\"></script>";
                echo "<script src=\"public/js/geraTabelaRespondente.js\"></script>";
            } else if ($tipoLista == "Vinculo"){
                echo "
                <script data-tipo_tabela=\"Vinculo\">
                    var params = \"qId={$_GET['questionarioId']}\"
                    var qId = {$_GET['questionarioId']}
                </script>";
                echo "<script id=\"tipo_tabela\" data-tipo_tabela=\"$tipoLista\" src=\"public/js/geraTabela.js\"></script>";
            } else {
                if (isset($objs)){
                    echo "<script type=\"application/javascript\"> const newObj = ".json_encode(json_decode($objs))."; </script>";
                }
                echo "<script id=\"tipo_tabela\" data-tipo_tabela=\"$tipoLista\" src=\"public/js/geraTabela.js\"></script>";
            }
        }
    ?>

    <title>
        <?php echo $titulo ?>
    </title>
</head>

<body class="bg-light">
    <header class="text-center align-middle">
        <nav class="py-2 d-flex flex-col flex-wrap flex-sm-row flex-sm-nowrap justify-content-around align-content-center" style="background-color: #606060;">
            <div class="align-self-center w-100">
                <a class="my-2" href="Menu.php">
                    <img src="public/imagens/ucs.png" width="100" class="d-inline-block align-middle" alt="Logo">
                </a>
            </div>

            <div class="align-self-center py-3 py-sm-0 w-100">
                <h3 class="my-0 mx-auto text-white align-middle"><?= $titulo ?></h3>
            </div>
            
            <div class="justify-content-center align-self-center d-flex flex-column w-100">
                <?php
                    include_once "Comum.php";
                    
                    if (is_session_started() === FALSE) {
                        session_start();
                    }
                    
                    if(isset($_SESSION["nome_usuario"])) {
                        echo "<span class=\"usuarioLogado d-block\">Login | " . $_SESSION["nome_usuario"];		
                        echo "<a href='ExecutaLogout.php' class=\"usuarioLogado d-block\">Logout <i class=\"px-2 bi bi-box-arrow-right\"></i> </a></span>";
                    } else {
                        echo "<a href='index.php' class=\"usuarioLogado d-block\"> Efetuar Login </a></span>";
                    }
                    ?>
            </div>
        </nav>
    </header>