<?php 
// Inicia sessões 
include_once "comum.php";
		
if ( is_session_started() === FALSE ) {
    error_log("nova sessao criada");
    session_start();
}

error_log("LOGIN");

// admin também é elaborador, então ele tem acesso
if(!$_SESSION["is_elaborador"] || !isset($_SESSION["id_elaborador"])) 
{   
    error_log("SEM ELABORADOR LOGADO - Vai para Menu.php");
    header("Location: Menu.php"); 
    exit; 
} 
?>