<?php 
// Inicia sessões 
include_once "comum.php";
		
if ( is_session_started() === FALSE ) {
    error_log("nova sessao criada");
    session_start();
}

error_log("LOGIN");

// Verifica se existe os dados da sessão de login 
if(!isset($_SESSION["id_usuario"]) && !$_SESSION["is_elaborador"] && !$_SESSION["is_admin"]) 
{ 
    error_log("SEM ELABORADOR LOGADO - Vai para index.php");

    // Usuário não logado! Redireciona para a página de login 
    header("Location: index.php"); 
    exit; 
} 
?>