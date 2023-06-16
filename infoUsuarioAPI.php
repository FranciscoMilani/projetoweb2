<?php

// Métodos de acesso ao banco de dados 
require "fachada.php";

$dao = $factory->getRespondenteDao();

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Busca todos respondentes
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $respJSON = $dao->buscaRespondenteJSON($id);
            if ($respJSON != null) {
                echo $respJSON;
                http_response_code(200); // 200 OK
            } else {
                http_response_code(404); // 404 Not Found
            }
        } //Busca uma turma
        else {
            echo $dao->buscaRespondentesJSON();
            http_response_code(200); // 200 OK
        }
        break;
    case 'POST':
        // insere um respondente
        $data = json_decode(file_get_contents('php://input'), true);
        $login = $data["login"];
        $senha = $data["senha"];
        $nome = $data["nome"];
        $email = @$data["email"];
        $telefone = $data["telefone"];
        $respondente = new Respondente(null, $login, $senha, $nome, $email, $telefone);
        $dao->insere($respondente);
        http_response_code(201); // 201 Created
        break;
    case 'DELETE':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $dao->remove($id);
            http_response_code(204); // 204 Deleted
        }
        break;
    case 'PUT':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $respondente = $dao->buscaPorId($id);
            if ($turma != null) {
                $data = json_decode(file_get_contents('php://input'), true);
                $respondente->setLogin($data["login"]);
                $respondente->setSenha($data["senha"]);
                $respondente->setNome($data["nome"]);
                $respondente->setEmail($data["email"]);
                $respondente->setTelefone($data["telefone"]);
                $dao->altera($respondente);
                http_response_code(200); // 200 OK
            } else {
                http_response_code(404); // 404 Not Found
            }
        }
        break;
    default:
        // Invalid Request Method
        http_response_code(405); // 405 Method Not Allowed
        break;
}