<?php

// Métodos de acesso ao banco de dados 
require "fachada.php"; 

$dao = $factory->getRespondenteDao();

$request_method=$_SERVER["REQUEST_METHOD"];
	
switch($request_method)
 {
 case 'GET':
    // Busca todos respondentes
    if(!empty($_GET["id"]))
    {
        $id=intval($_GET["id"]);
        $respJSON = $dao->buscaRespondenteJSON($id);
        if($respJSON!=null) {
            echo $respJSON;
            http_response_code(200); // 200 OK
        } else {
            http_response_code(404); // 404 Not Found
        }
    } //Busca uma turma
    else
    {
        echo $dao->buscaRespondentesJSON();
        http_response_code(200); // 200 OK
    }
    break;

 default:
    // Invalid Request Method
    http_response_code(405); // 405 Method Not Allowed
    break;
 }