<?php
// validar sessão
include "verificaUsuarios.php";

$titulo = "Lista de Ofertas";
include_once 'LayoutHeader.php';

//Antes da tela de lista de ofertas, talvez criar uma tela "menu" onde terá diferentes botões dependendo do usuário, como botão para
// cadastro de novos elaboradores, botão para cadastro de questionário, cadastro de alternativas..

//verifica se é adm para ter funções diferentes
if (isset($_SESSION["id_elaborador"])) {
    echo "Este é um usuário elaborador ";
} else {
    echo "usuário normal";
}

if ($_SESSION["is_admin"]) {
    echo "Este é um usuário adm ";
} else {
    echo "não é usuário adm";
}
?>