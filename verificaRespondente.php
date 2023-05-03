<?php 
// Inicia sessões 
include_once "comum.php";
		
if ( is_session_started() === FALSE ) {
    session_start();
}

error_log("LOGIN");

if (!isset($_SESSION["id_usuario"]) || ($_SESSION["is_elaborador"] || $_SESSION["is_admin"]))
{ 
    error_log("SEM RESPONDENTE LOGADO - Vai para Menu.php");
    header("Location: Menu.php"); 
    exit; 
} 

?>