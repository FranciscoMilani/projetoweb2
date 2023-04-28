<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <script
        src="https://code.jquery.com/jquery-3.6.4.js"
        integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
        crossorigin="anonymous"></script>

    <title>
        <?php echo $titulo ?>
    </title>
</head>

<body class="bg-light">
    <header class="container mx-auto mw-100 text-center align-middle">
        <nav class="row bg-secondary">
        <a class="col my-2" href="Menu.php">
            <img src="imagens/ucs.png" width="100" class="d-inline-block align-middle" alt="Logo">
        </a>
        <div class="col d-flex align-self-center">
            <h3 class="my-0 mx-auto text-white align-middle"><?= $titulo ?></h3>
        </div>
        <div class="col d-flex justify-content-center align-self-center flex-column">
            <?php
                include_once "Comum.php";
                
                if (is_session_started() === FALSE) {
                    session_start();
                }
                
                if(isset($_SESSION["nome_usuario"])) {
                    echo "<span class=\"usuarioLogado d-block\">Login | " . $_SESSION["nome_usuario"];		
                    echo "<a href='ExecutaLogout.php' class=\"usuarioLogado d-block\"> Logout </a></span>";
                } else {
                    echo "<a href='index.php' class=\"usuarioLogado d-block\"> Efetuar Login </a></span>";
                }
                ?>
            <div>
        </nav>
    </header>