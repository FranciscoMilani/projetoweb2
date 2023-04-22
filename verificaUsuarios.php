<?php 
// Inicia sessões 
include_once "comum.php";
		
if ( is_session_started() === FALSE ) {
    session_start();
}

error_log("LOGIN");

// Verifica se existe os dados da sessão de login 
if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"])) 
{ 
    error_log("SEM USUÁRIO LOGADO - Vai para index.php");
    
    // Usuário não logado! Redireciona para a página de login 
    header("Location: index.php"); 
    exit; 
} 
?>