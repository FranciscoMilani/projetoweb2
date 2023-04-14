<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    <title><?php echo $titulo ?></title>
</head>

<body>
    <header>
        <div>
            <?php 
                include_once "Comum.php";
                
                if ( is_session_started() === FALSE ) {
                    session_start();
                }	

                // if(isset($_SESSION["nome_usuario"])) {
                //     echo "<span>Você está logado como " . $_SESSION["nome_usuario"];		
                //     echo "<a href='ExecutaLogout.php'> Logout </a></span>";
                // } else {
                //     echo "<span><a href='Login.php'> Efetuar Login </a></span>";
                // }
            ?>	
        </div>